<?php

class EnderecoDAO {
    private $conexao;

    public function __construct() {
        include_once 'src/config/config.php';
        $this->conexao = Config::conexaoPDO();
    }

    public function getEnderecoById($id): array {
        try {
            $stmt = $this->conexao->prepare("SELECT * FROM enderecos WHERE idEndereco = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Erro ao buscar endereço: " . $e->getMessage();
            return [];
        }
    }

    public function listarEnderecos(): array {
        try {
            $stmt = $this->conexao->query("SELECT * FROM enderecos ORDER BY nomeEndereco");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar endereços: " . $e->getMessage();
            return [];
        }
    }

    public function cadastrarEndereco($nome, $logradouro, $bairro, $cidade, $estado, $cep = '', $valorConsumo = 0, $valorPermanente = 0): bool {
        try {
            $stmt = $this->conexao->prepare(
                "INSERT INTO enderecos (nomeEndereco, logradouroEndereco, bairroEndereco, cidadeEndereco, estadoEndereco, cepEndereco, valorConsumo, valorPermanente) VALUES (:nome, :logradouro, :bairro, :cidade, :estado, :cep, :valorConsumo, :valorPermanente)"
            );
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':logradouro', $logradouro, PDO::PARAM_STR);
            $stmt->bindValue(':bairro', $bairro, PDO::PARAM_STR);
            $stmt->bindValue(':cidade', $cidade, PDO::PARAM_STR);
            $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindValue(':cep', $cep, PDO::PARAM_STR);
            $stmt->bindValue(':valorConsumo', $valorConsumo, PDO::PARAM_STR);
            $stmt->bindValue(':valorPermanente', $valorPermanente, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao cadastrar endereço: " . $e->getMessage();
            return false;
        }
    }

    public function editarEndereco($id, $nome, $logradouro, $bairro, $cidade, $estado, $cep = '', $valorConsumo = 0, $valorPermanente = 0): bool {
        try {
            $stmt = $this->conexao->prepare(
                "UPDATE enderecos SET nomeEndereco = :nome, logradouroEndereco = :logradouro, bairroEndereco = :bairro, cidadeEndereco = :cidade, estadoEndereco = :estado, cepEndereco = :cep, valorConsumo = :valorConsumo, valorPermanente = :valorPermanente WHERE idEndereco = :id"
            );
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':logradouro', $logradouro, PDO::PARAM_STR);
            $stmt->bindValue(':bairro', $bairro, PDO::PARAM_STR);
            $stmt->bindValue(':cidade', $cidade, PDO::PARAM_STR);
            $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindValue(':cep', $cep, PDO::PARAM_STR);
            $stmt->bindValue(':valorConsumo', $valorConsumo, PDO::PARAM_STR);
            $stmt->bindValue(':valorPermanente', $valorPermanente, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao editar endereço: " . $e->getMessage();
            return false;
        }
    }

    public function excluirEndereco($id): bool {
        try {
            $stmt = $this->conexao->prepare("SELECT COUNT(*) FROM guias WHERE destinoGuia = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                echo "Erro ao excluir endereço: existem guias cadastradas que usam esse endereço como destino.";
                return false;
            }

            $stmt = $this->conexao->prepare("DELETE FROM enderecos WHERE idEndereco = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao excluir endereço: " . $e->getMessage();
            return false;
        }
    }

}
