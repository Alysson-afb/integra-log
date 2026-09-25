<?php

class UsuarioDAO {
    private $conexao;

    public function __construct() {
        include_once 'src/config/config.php';
        $this->conexao = Config::conexaoPDO();
    }

    public function getUsuarioById($id): array {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM usuarios WHERE idUsuario = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Erro ao buscar usuário: " . $e->getMessage();
            return [];
        }
    }

    public function getUsuarioByEmail($email): array {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM usuarios WHERE emailUsuario = :email");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Erro ao buscar usuário: " . $e->getMessage();
            return [];
        }
    }

    public function listarUsuarios(): array {
        try {
            $stmt = $this->conexao->query("SELECT * FROM usuarios ORDER BY nomeUsuario");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar usuários: " . $e->getMessage();
            return [];
        }
    }

    public function existeEmailUsuario($email, $idIgnorar = null): bool {
        try {
            if ($idIgnorar) {
                $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM usuarios WHERE emailUsuario = :email AND idUsuario != :idIgnorar");
                $stmt->bindValue(':idIgnorar', $idIgnorar, PDO::PARAM_INT);
            } else {
                $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM usuarios WHERE emailUsuario = :email");
            }
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            echo "Erro ao verificar e-mail do usuário: " . $e->getMessage();
            return false;
        }
    }

    public function cadastrarUsuario($nome, $email, $senhaHash, $cargo): bool {
        try {
            $stmt = $this->conexao->prepare(
                "INSERT INTO usuarios (nomeUsuario, emailUsuario, senhaUsuario, cargoUsuario) VALUES (:nome, :email, :senha, :cargo)"
            );
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':senha', $senhaHash, PDO::PARAM_STR);
            $stmt->bindValue(':cargo', $cargo, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
            return false;
        }
    }

    public function editarUsuario($id, $nome, $email, $cargo, $senhaHash = null): bool {
        try {
            if ($senhaHash) {
                $stmt = $this->conexao->prepare(
                    "UPDATE usuarios SET nomeUsuario = :nome, emailUsuario = :email, cargoUsuario = :cargo, senhaUsuario = :senha WHERE idUsuario = :id"
                );
                $stmt->bindValue(':senha', $senhaHash, PDO::PARAM_STR);
            } else {
                $stmt = $this->conexao->prepare(
                    "UPDATE usuarios SET nomeUsuario = :nome, emailUsuario = :email, cargoUsuario = :cargo WHERE idUsuario = :id"
                );
            }
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':cargo', $cargo, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao editar usuário: " . $e->getMessage();
            return false;
        }
    }

    public function excluirUsuario($id): bool {
        try {
            $stmt = $this->conexao->prepare("DELETE FROM usuarios WHERE idUsuario = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir usuário: " . $e->getMessage();
            return false;
        }
    }

}
