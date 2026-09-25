<?php

class MotoristaDAO {
    private $conexao;

    public function __construct() {
        include_once 'src/config/config.php';
        $this->conexao = Config::conexaoPDO();
    }

    public function getMotoristaById($id): array {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM motoristas WHERE idMotorista = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Erro ao buscar motorista: " . $e->getMessage();
            return [];
        }
    }

    public function listarMotoristas(): array {
        try {
            $stmt = $this->conexao->query("SELECT * FROM motoristas ORDER BY nomeMotorista ASC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar motoristas: " . $e->getMessage();
            return [];
        }
    }

    public function cadastrarMotorista($nome, $email, $cpf, $cnh, $telefone): bool {
        try {
            $stmt = $this->conexao->prepare(
                "INSERT INTO motoristas (nomeMotorista, emailMotorista, cpfMotorista, cnhMotorista, telefoneMotorista) VALUES (:nome, :email, :cpf, :cnh, :telefone)"
            );
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindValue(':cnh', $cnh, PDO::PARAM_STR);
            $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar motorista: " . $e->getMessage();
            return false;
        }
    }

    public function editarMotorista($id, $nome, $email, $cpf, $cnh, $telefone): bool {
        try {
            $stmt = $this->conexao->prepare(
                "UPDATE motoristas SET nomeMotorista = :nome, emailMotorista = :email, cpfMotorista = :cpf, cnhMotorista = :cnh, telefoneMotorista = :telefone WHERE idMotorista = :id"
            );
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindValue(':cnh', $cnh, PDO::PARAM_STR);
            $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao editar motorista: " . $e->getMessage();
            return false;
        }
    }

    public function excluirMotorista($id): bool {
        try {
            $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM guias WHERE motoristaGuia = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                echo "Erro ao excluir motorista: existem guias cadastradas associadas a este motorista.";
                return false;
            }

            $stmt = $this->conexao->prepare("DELETE FROM motoristas WHERE idMotorista = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir motorista: " . $e->getMessage();
            return false;
        }
    }
    
}
