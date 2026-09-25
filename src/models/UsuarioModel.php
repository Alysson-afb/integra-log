<?php

class UsuarioModel {

    public function getUsuarioById($id): array {
        require_once 'src/dao/UsuarioDAO.php';
        $dao = new UsuarioDAO();
        return $dao->getUsuarioById($id);
    }

    public function listarUsuarios(): array {
        require_once 'src/dao/UsuarioDAO.php';
        $dao = new UsuarioDAO();
        return $dao->listarUsuarios();
    }

    public function existeEmailUsuario($email, $idIgnorar = null): bool {
        require_once 'src/dao/UsuarioDAO.php';
        $dao = new UsuarioDAO();
        return $dao->existeEmailUsuario($email, $idIgnorar);
    }

    public function cadastrarUsuario($nome, $email, $senha, $cargo): bool {
        require_once 'src/dao/UsuarioDAO.php';
        $dao = new UsuarioDAO();
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        return $dao->cadastrarUsuario($nome, $email, $senhaHash, $cargo);
    }

    public function editarUsuario($id, $nome, $email, $cargo, $senha = ''): bool {
        require_once 'src/dao/UsuarioDAO.php';
        $dao = new UsuarioDAO();
        $senhaHash = $senha ? password_hash($senha, PASSWORD_DEFAULT) : null;
        return $dao->editarUsuario($id, $nome, $email, $cargo, $senhaHash);
    }

    public function excluirUsuario($id): bool {
        require_once 'src/dao/UsuarioDAO.php';
        $dao = new UsuarioDAO();
        return $dao->excluirUsuario($id);
    }

    public function verificarLogin($email, $senha): array {
        require_once 'src/dao/UsuarioDAO.php';
        $dao = new UsuarioDAO();
        $usuario = $dao->getUsuarioByEmail($email);

        if ($usuario && password_verify($senha, $usuario['senhaUsuario'])) {
            return $usuario;
        }

        return [];
    }

}
