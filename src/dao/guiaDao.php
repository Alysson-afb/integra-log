<?php

class GuiaDAO {
    private $conexao;

    public function __construct() {
        include_once 'src/config/config.php';
        $this->conexao = Config::conexaoPDO();
    }

    public function getGuiaById($id) {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM guias WHERE idGuia = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Erro ao buscar guia: " . $e->getMessage();
            return [];
        }
    }
    
    public function getGuiaByNumero($numeroGuia): array {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM guias WHERE numeroGuia = :numeroGuia");
            $stmt->bindValue(':numeroGuia', $numeroGuia, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Erro ao buscar guia pelo número: " . $e->getMessage();
            return [];
        }
    }

    public function listarGuias($mes = null, $ano = null): array {
        try {
            $sql = "SELECT guias.*, enderecos.nomeEndereco, motoristas.nomeMotorista
                    FROM guias
                    INNER JOIN enderecos ON enderecos.idEndereco = guias.destinoGuia
                    INNER JOIN motoristas ON motoristas.idMotorista = guias.motoristaGuia";
                             
            // Adiciona o filtro caso os parâmetros sejam informados
            if ($mes && $ano) {
                $sql .= " WHERE MONTH(guias.dataEmissaoGuia) = :mes AND YEAR(guias.dataEmissaoGuia) = :ano";
            }
                     
            // Garante que o último registro adicionado no banco fique sempre no topo
            $sql .= " ORDER BY guias.idGuia DESC";
                     
            $stmt = $this->conexao->prepare($sql);
                     
            if ($mes && $ano) {
                $stmt->bindValue(':mes', $mes, PDO::PARAM_INT);
                $stmt->bindValue(':ano', $ano, PDO::PARAM_INT);
            }
                     
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar guias: " . $e->getMessage();
            return [];
        }
    }

    public function existeNumeroGuia($numeroGuia, $idIgnorar = null): bool {
        try {
            if ($idIgnorar) {
                $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM guias WHERE numeroGuia = :numeroGuia AND idGuia != :idIgnorar");
                $stmt->bindValue(':idIgnorar', $idIgnorar, PDO::PARAM_INT);
            } else {
                $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM guias WHERE numeroGuia = :numeroGuia");
            }
            $stmt->bindValue(':numeroGuia', $numeroGuia, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            echo "Erro ao verificar número da guia: " . $e->getMessage();
            return false;
        }
    }

    public function cadastrarGuia($numeroGuia, $dataEmissaoGuia, $destinoGuia, $tipoTransporteGuia, $motoristaGuia, $modalidadeGuia, $pesoGuia, $valorFrete, $statusGuia): bool {
        try {
            $stmt = $this->conexao->prepare(
                "INSERT INTO guias (numeroGuia, dataEmissaoGuia, destinoGuia, tipoTransporteGuia, motoristaGuia, modalidadeGuia, pesoGuia, valorFrete, statusGuia) VALUES (:numeroGuia, :dataEmissaoGuia, :destinoGuia, :tipoTransporteGuia, :motoristaGuia, :modalidadeGuia, :pesoGuia, :valorFrete, :statusGuia)"
            );
            $stmt->bindValue(':numeroGuia', $numeroGuia, PDO::PARAM_STR);
            $stmt->bindValue(':dataEmissaoGuia', $dataEmissaoGuia ?: date('Y-m-d'), PDO::PARAM_STR);
            $stmt->bindValue(':destinoGuia', $destinoGuia, PDO::PARAM_INT);
            $stmt->bindValue(':tipoTransporteGuia', $tipoTransporteGuia, PDO::PARAM_INT);
            $stmt->bindValue(':motoristaGuia', $motoristaGuia, PDO::PARAM_INT);
            $stmt->bindValue(':modalidadeGuia', $modalidadeGuia, PDO::PARAM_INT);
            $stmt->bindValue(':pesoGuia', $pesoGuia, PDO::PARAM_STR);
            $stmt->bindValue(':valorFrete', $valorFrete, PDO::PARAM_STR);
            $stmt->bindValue(':statusGuia', $statusGuia, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar guia: " . $e->getMessage();
            return false;
        }
    }

    public function editarGuia($idGuia, $numeroGuia, $dataEmissaoGuia, $destinoGuia, $tipoTransporteGuia, $motoristaGuia, $modalidadeGuia, $pesoGuia, $valorFrete, $statusGuia): bool {
        try {
            $stmt = $this->conexao->prepare(
                "UPDATE guias SET numeroGuia = :numeroGuia, dataEmissaoGuia = :dataEmissaoGuia, destinoGuia = :destinoGuia, tipoTransporteGuia = :tipoTransporteGuia, motoristaGuia = :motoristaGuia, modalidadeGuia = :modalidadeGuia, pesoGuia = :pesoGuia, valorFrete = :valorFrete, statusGuia = :statusGuia WHERE idGuia = :idGuia"
            );
            $stmt->bindValue(':idGuia', $idGuia, PDO::PARAM_INT);
            $stmt->bindValue(':numeroGuia', $numeroGuia, PDO::PARAM_STR);
            $stmt->bindValue(':dataEmissaoGuia', $dataEmissaoGuia ?: date('Y-m-d'), PDO::PARAM_STR);
            $stmt->bindValue(':destinoGuia', $destinoGuia, PDO::PARAM_INT);
            $stmt->bindValue(':tipoTransporteGuia', $tipoTransporteGuia, PDO::PARAM_INT);
            $stmt->bindValue(':motoristaGuia', $motoristaGuia, PDO::PARAM_INT);
            $stmt->bindValue(':modalidadeGuia', $modalidadeGuia, PDO::PARAM_INT);
            $stmt->bindValue(':pesoGuia', $pesoGuia, PDO::PARAM_STR);
            $stmt->bindValue(':valorFrete', $valorFrete, PDO::PARAM_STR);
            $stmt->bindValue(':statusGuia', $statusGuia, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao editar guia: " . $e->getMessage();
            return false;
        }
    }

    public function excluirGuia($id): bool {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM guias WHERE idGuia = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir guia: " . $e->getMessage();
            return false;
        }
    }

    public function atualizarStatus($id, $status): bool {
    try {
        $stmt = $this->conexao->prepare("UPDATE guias SET statusGuia = :status WHERE idGuia = :id");
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Erro ao atualizar status da guia: " . $e->getMessage();
        return false;
    }
}
    
}
