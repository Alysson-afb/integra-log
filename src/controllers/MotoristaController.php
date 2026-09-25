<?php

class MotoristaController {

    public static function home() {
        require 'src/views/home.php';
    }

    public static function getMotoristaById($id): array {
        require_once 'src/models/MotoristaModel.php';
        $model = new MotoristaModel();
        return $model->getMotoristaById($id);
    }

    public static function listarMotoristas(): array {
        require_once 'src/models/MotoristaModel.php';
        $model = new MotoristaModel();
        $motoristas = $model->listarMotoristas();
        require 'src/views/visualizar-motoristas.php';
        return $motoristas;
    }

    public static function cadastrarMotorista(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'src/models/MotoristaModel.php';
            $model = new MotoristaModel();

            $nome = $_POST['containerNome'];
            $email = $_POST['containerEmail'];
            $cpf = $_POST['containerCpf'];
            $cnh = $_POST['containerCnh'];
            $telefone = $_POST['containerTelefone'];

            if ($model->cadastrarMotorista($nome, $email, $cpf, $cnh, $telefone)) {
                header('Location: /projetos-php/integra-log/home');
                exit();
            } else {
                echo "Erro ao cadastrar motorista.";
            }
            return;
        }

        require 'src/views/cadastrar-motorista.php';
    }

    public static function editarMotorista($id) {
        require_once 'src/models/MotoristaModel.php';
        $model = new MotoristaModel();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['containerNome'];
            $email = $_POST['containerEmail'];
            $cpf = $_POST['containerCpf'];
            $cnh = $_POST['containerCnh'];
            $telefone = $_POST['containerTelefone'];

            if ($model->editarMotorista($id, $nome, $email, $cpf, $cnh, $telefone)) {
                header('Location: /projetos-php/integra-log/visualizar-motoristas');
                exit();
            } else {
                echo "Erro ao atualizar motorista.";
            }
            return;
        }

        $motorista = $model->getMotoristaById($id);
        require 'src/views/editar-motorista.php';
    }

    public static function excluirMotorista($id): void {
        require_once 'src/models/MotoristaModel.php';
        $model = new MotoristaModel();

        if ($model->excluirMotorista($id)) {
            header('Location: /projetos-php/integra-log/visualizar-motoristas');
            exit();
        } else {
            echo "Erro ao excluir motorista.";
        }
    }
    
}
