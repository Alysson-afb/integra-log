<?php

class EnderecoModel {

    public function getEnderecoById($id): array {
        require_once 'src/dao/EnderecoDAO.php';
        $dao = new EnderecoDAO();
        return $dao->getEnderecoById($id);
    }

    public function listarEnderecos(): array {
        require_once 'src/dao/EnderecoDAO.php';
        $dao = new EnderecoDAO();
        return $dao->listarEnderecos();
    }

    public function cadastrarEndereco($nome, $logradouro, $bairro, $cidade, $estado, $cep = '', $valorConsumo = 0, $valorPermanente = 0): bool {
        require_once 'src/dao/EnderecoDAO.php';
        $dao = new EnderecoDAO();
        return $dao->cadastrarEndereco($nome, $logradouro, $bairro, $cidade, $estado, $cep, $valorConsumo, $valorPermanente);
    }

    public function editarEndereco($id, $nome, $logradouro, $bairro, $cidade, $estado, $cep = '', $valorConsumo = 0, $valorPermanente = 0): bool {
        require_once 'src/dao/EnderecoDAO.php';
        $dao = new EnderecoDAO();
        return $dao->editarEndereco($id, $nome, $logradouro, $bairro, $cidade, $estado, $cep, $valorConsumo, $valorPermanente);
    }

    public function excluirEndereco($id): bool {
        require_once 'src/dao/EnderecoDAO.php';
        $dao = new EnderecoDAO();
        return $dao->excluirEndereco($id);
    }

}
