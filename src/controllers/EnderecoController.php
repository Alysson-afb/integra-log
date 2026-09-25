<?php

class EnderecoController {

    public static function home() {
        require 'src/views/home.php';
    }

    public static function getEnderecoById($id): array {
        require_once 'src/models/EnderecoModel.php';
        $model = new EnderecoModel();
        return $model->getEnderecoById($id);
    }

    public static function excluirEndereco($id): void {
        require_once 'src/models/EnderecoModel.php';
        $model = new EnderecoModel();

        if ($model->excluirEndereco($id)) {
            header('Location: /projetos-php/integra-log/visualizar-enderecos');
            exit();
        } else {
            echo "Erro ao excluir endereço.";
        }
    }

    public static function listarEnderecos(): array {
        require_once 'src/models/EnderecoModel.php';
        $model = new EnderecoModel();
        $enderecos = $model->listarEnderecos();
        require 'src/views/visualizar-enderecos.php';
        return $enderecos;
    }

    public static function cadastrarEndereco(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'src/models/EnderecoModel.php';
            $model = new EnderecoModel();

            $nome = $_POST['containerNome'];
            $logradouro = $_POST['containerLogradouro'];
            $bairro = $_POST['containerBairro'];
            $cidade = $_POST['containerCidade'];
            $estado = $_POST['containerEstado'];
            $cep = $_POST['containerCep'];
            $valorConsumo = $_POST['containerValorConsumo'];
            $valorPermanente = $_POST['containerValorPermanente'];

            if ($model->cadastrarEndereco($nome, $logradouro, $bairro, $cidade, $estado, $cep, $valorConsumo, $valorPermanente)) {
                header('Location: /projetos-php/integra-log/home');
                exit();
            } else {
                echo "Erro ao cadastrar endereço.";
            }
            return;
        }
        require 'src/views/cadastrar-endereco.php';
    }

    public static function editarEndereco($id): void {
        require_once 'src/models/EnderecoModel.php';
        $model = new EnderecoModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['containerNome'];
            $logradouro = $_POST['containerLogradouro'];
            $bairro = $_POST['containerBairro'];
            $cidade = $_POST['containerCidade'];
            $estado = $_POST['containerEstado'];
            $cep = $_POST['containerCep'];
            $valorConsumo = $_POST['containerValorConsumo'];
            $valorPermanente = $_POST['containerValorPermanente'];

            if ($model->editarEndereco($id, $nome, $logradouro, $bairro, $cidade, $estado, $cep, $valorConsumo, $valorPermanente)) {
                header('Location: /projetos-php/integra-log/visualizar-enderecos');
                exit();
            } else {
                echo "Erro ao atualizar endereço.";
            }
            return;
        }

        $endereco = $model->getEnderecoById($id);
        require 'src/views/editar-endereco.php';
    }

}
