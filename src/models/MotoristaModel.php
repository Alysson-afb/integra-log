<?php

class MotoristaModel {

    public function getMotoristaById($id): array {
        require_once 'src/dao/MotoristaDAO.php';
        $dao = new MotoristaDAO();
        return $dao->getMotoristaById($id);
    }
    
    public function listarMotoristas(): array {
        require_once 'src/dao/MotoristaDAO.php';
        $dao = new MotoristaDAO();
        return $dao->listarMotoristas();
    }

    public function cadastrarMotorista($nome, $email, $cpf, $cnh, $telefone): bool {
        require_once 'src/dao/MotoristaDAO.php';
        $dao = new MotoristaDAO();
        return $dao->cadastrarMotorista($nome, $email, $cpf, $cnh, $telefone);
    }

    public function editarMotorista($id, $nome, $email, $cpf, $cnh, $telefone): bool {
        require_once 'src/dao/MotoristaDAO.php';
        $dao = new MotoristaDAO();
        return $dao->editarMotorista($id, $nome, $email, $cpf, $cnh, $telefone);
    }

    public function excluirMotorista($id): bool {
        require_once 'src/dao/MotoristaDAO.php';
        $dao = new MotoristaDAO();
        return $dao->excluirMotorista($id);
    }

}
