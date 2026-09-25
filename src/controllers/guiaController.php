<?php

class GuiaController {

    public static function home() {
        require 'src/views/home.php';
    }

    public static function getGuiaById($id): array {
        require_once 'src/models/GuiaModel.php';
        $model = new GuiaModel();
        return $model->getGuiaById($id);
    }

    public static function listarGuias(): array {
        require_once 'src/models/GuiaModel.php';
        $model = new GuiaModel();

        // Pega da URL ou define o mês/ano atual por padrão
        $mes = isset($_GET['mes']) ? (int)$_GET['mes'] : (int)date('m');
        $ano = isset($_GET['ano']) ? (int)$_GET['ano'] : (int)date('Y');

        $guias = $model->listarGuias($mes, $ano);

        require 'src/views/visualizar-guias.php';
        return $guias;
    }

    public static function cadastrarGuia(): void {
        require_once 'src/models/GuiaModel.php';
        require_once 'src/models/MotoristaModel.php';
        require_once 'src/models/EnderecoModel.php';
        require_once 'src/models/GuiaStatusHistoricoModel.php';

        $model = new GuiaModel();
        $motoristaModel = new MotoristaModel();
        $enderecoModel = new EnderecoModel();
        $historicoModel = new GuiaStatusHistoricoModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numeroGuia = $_POST['containerNumeroGuia'];
            $dataEmissaoGuia = $_POST['containerDataEmissaoGuia'];
            $destinoGuia = $_POST['containerDestinoGuia'];
            $tipoTransporteGuia = $_POST['containerTipoTransporteGuia'];
            $motoristaGuia = $_POST['containerMotoristaGuia'];
            $modalidadeGuia = $_POST['containerModalidadeGuia'];
            $pesoGuia = $_POST['containerPesoGuia'];
            $statusGuia = $_POST['containerStatusGuia'];

            if ($model->existeNumeroGuia($numeroGuia)) {
                echo "Já existe uma guia cadastrada com esse número.";
                return;
            }

            $endereco = $enderecoModel->getEnderecoById($destinoGuia);

            if ($modalidadeGuia == 2) {
                $valorKg = $endereco['valorPermanente'];
            } else {
                $valorKg = $endereco['valorConsumo'];
            }

            $valorFrete = $pesoGuia * $valorKg;

            if ($model->cadastrarGuia($numeroGuia, $dataEmissaoGuia, $destinoGuia, $tipoTransporteGuia, $motoristaGuia, $modalidadeGuia, $pesoGuia, $valorFrete, $statusGuia)) {
                $guiaCadastrada = $model->getGuiaByNumero($numeroGuia);
                $historicoModel->registrarMudancaStatus($guiaCadastrada['idGuia'], $_SESSION['idUsuario'], null, $statusGuia, 'Guia cadastrada no sistema.');
                
                header('Location: /projetos-php/integra-log/home');
                exit();
            } else {
                echo "Erro ao cadastrar guia.";
            }
            return;
        }

        $motoristas = $motoristaModel->listarMotoristas();
        $enderecos = $enderecoModel->listarEnderecos();
        require 'src/views/cadastrar-guia.php';
    }

    public static function editarGuia($id): void {
        require_once 'src/models/GuiaModel.php';
        require_once 'src/models/MotoristaModel.php';
        require_once 'src/models/EnderecoModel.php';
        require_once 'src/models/GuiaStatusHistoricoModel.php';

        $model = new GuiaModel();
        $motoristaModel = new MotoristaModel();
        $enderecoModel = new EnderecoModel();
        $historicoModel = new GuiaStatusHistoricoModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idGuia = $id;
            $numeroGuia = $_POST['containerNumeroGuia'];
            $dataEmissaoGuia = $_POST['containerDataEmissaoGuia'];
            $destinoGuia = $_POST['containerDestinoGuia'];
            $tipoTransporteGuia = $_POST['containerTipoTransporteGuia'];
            $motoristaGuia = $_POST['containerMotoristaGuia'];
            $modalidadeGuia = $_POST['containerModalidadeGuia'];
            $pesoGuia = $_POST['containerPesoGuia'];
            $statusGuia = $_POST['containerStatusGuia'];
            $observacaoHistorico = $_POST['containerObservacaoHistorico'];

            if ($model->existeNumeroGuia($numeroGuia, $idGuia)) {
                echo "Já existe uma guia cadastrada com esse número.";
                return;
            }

            $guiaAtual = $model->getGuiaById($idGuia);

            if ($guiaAtual['pesoGuia'] == $pesoGuia
                && $guiaAtual['destinoGuia'] == $destinoGuia
                && $guiaAtual['modalidadeGuia'] == $modalidadeGuia) {

                $valorFrete = $guiaAtual['valorFrete'];

            } else {

                $endereco = $enderecoModel->getEnderecoById($destinoGuia);

                if (empty($endereco)) {
                    echo "Erro ao atualizar guia: endereço de destino não encontrado.";
                    return;
                }

                if ($modalidadeGuia == 2) {
                    $valorKg = $endereco['valorPermanente'];
                } else {
                    $valorKg = $endereco['valorConsumo'];
                }

                $valorFrete = $pesoGuia * $valorKg;
            }

            if ($model->editarGuia($idGuia, $numeroGuia, $dataEmissaoGuia, $destinoGuia, $tipoTransporteGuia, $motoristaGuia, $modalidadeGuia, $pesoGuia, $valorFrete, $statusGuia)) {
                if ($guiaAtual['statusGuia'] != $statusGuia) {
                    $historicoModel->registrarMudancaStatus($idGuia, $_SESSION['idUsuario'], $guiaAtual['statusGuia'], $statusGuia, $observacaoHistorico);
                }
                
                header('Location: /projetos-php/integra-log/visualizar-guias');
                exit();
            } else {
                echo "Erro ao atualizar guia.";
            }
            return;
        }

        $guia = $model->getGuiaById($id);
        $motoristas = $motoristaModel->listarMotoristas();
        $enderecos = $enderecoModel->listarEnderecos();
        require 'src/views/editar-guia.php';
    }

    public static function excluirGuia($id): void {
        require_once 'src/models/GuiaModel.php';
        $model = new GuiaModel();

        if ($model->excluirGuia($id)) {
            header('Location: /projetos-php/integra-log/visualizar-guias');
            exit();
        } else {
            echo "Erro ao excluir guia.";
        }
    }

    public static function visualizarHistorico($id): void {
        require_once 'src/models/GuiaModel.php';
        require_once 'src/models/GuiaStatusHistoricoModel.php';

        $model = new GuiaModel();
        $historicoModel = new GuiaStatusHistoricoModel();

        $guia = $model->getGuiaById($id);
        $historico = $historicoModel->listarHistoricoPorGuia($id);

        require 'src/views/visualizar-historico-guia.php';
    }

    public static function mudarStatus($id, $novoStatus): void {
        require_once 'src/models/GuiaModel.php';
        require_once 'src/models/GuiaStatusHistoricoModel.php';

        $model = new GuiaModel();
        $historicoModel = new GuiaStatusHistoricoModel();

        $id = (int)$id;
        $novoStatus = (int)$novoStatus;

        $guiaAtual = $model->getGuiaById($id);

        if (!empty($guiaAtual) && $guiaAtual['statusGuia'] != $novoStatus) {
            if ($model->atualizarStatus($id, $novoStatus)) {
                $historicoModel->registrarMudancaStatus(
                    $id,
                    $_SESSION['idUsuario'],
                    $guiaAtual['statusGuia'],
                    $novoStatus,
                    'Status alterado pelo atalho rápido do painel.'
                );
            }
        }

        // Redireciona de volta para a mesma tela e mês em que o usuário estava
        $origem = $_SERVER['HTTP_REFERER'] ?? '/projetos-php/integra-log/visualizar-guias';
        header('Location: ' . $origem);
        exit();
    }

    public static function portalMotorista(): void {
        require_once 'src/models/GuiaModel.php';
        $model = new GuiaModel();
        
        // Lista as guias (No próximo passo, podemos fazer com que liste apenas as guias do próprio motorista logado)
        $guias = $model->listarGuias(); 
        
        require 'src/views/portal-motorista.php';
    }
    
}
