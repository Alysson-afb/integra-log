<?php

class GuiaStatusHistoricoDAO {
    private $conexao;

    public function __construct() {
        include_once 'src/config/config.php';
        $this->conexao = Config::conexaoPDO();
    }

    public function registrarMudancaStatus($guiaHistorico, $usuarioHistorico, $statusAnterior, $statusNovo, $observacaoHistorico = null): bool {
        try {
            $stmt = $this->conexao->prepare(
                "INSERT INTO guiaStatusHistorico (guiaHistorico, usuarioHistorico, statusAnterior, statusNovo, observacaoHistorico) VALUES (:guia, :usuario, :statusAnterior, :statusNovo, :observacao)"
            );
            $stmt->bindValue(':guia', $guiaHistorico, PDO::PARAM_INT);
            $stmt->bindValue(':usuario', $usuarioHistorico, PDO::PARAM_INT);
            $stmt->bindValue(':statusNovo', $statusNovo, PDO::PARAM_INT);
            $stmt->bindValue(':observacao', $observacaoHistorico, PDO::PARAM_STR);

            if ($statusAnterior == null) {
                $stmt->bindValue(':statusAnterior', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':statusAnterior', $statusAnterior, PDO::PARAM_INT);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro ao registrar histórico da guia: " . $e->getMessage();
            return false;
        }
    }

    public function listarHistoricoPorGuia($idGuia): array {
        try {
            $stmt = $this->conexao->prepare(
                "SELECT guiaStatusHistorico.*, usuarios.nomeUsuario
                 FROM guiaStatusHistorico
                 LEFT JOIN usuarios ON usuarios.idUsuario = guiaStatusHistorico.usuarioHistorico
                 WHERE guiaStatusHistorico.guiaHistorico = :id
                 ORDER BY guiaStatusHistorico.dataHoraMudanca, guiaStatusHistorico.idHistorico"
            );
            $stmt->bindValue(':id', $idGuia, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao listar histórico da guia: " . $e->getMessage();
            return [];
        }
    }

}
