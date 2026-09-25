<?php

class GuiaStatusHistoricoModel {

    public function registrarMudancaStatus($guiaHistorico, $usuarioHistorico, $statusAnterior, $statusNovo, $observacaoHistorico = null): bool {
        require_once 'src/dao/GuiaStatusHistoricoDAO.php';
        $dao = new GuiaStatusHistoricoDAO();
        return $dao->registrarMudancaStatus($guiaHistorico, $usuarioHistorico, $statusAnterior, $statusNovo, $observacaoHistorico);
    }

    public function listarHistoricoPorGuia($idGuia): array {
        require_once 'src/dao/GuiaStatusHistoricoDAO.php';
        $dao = new GuiaStatusHistoricoDAO();
        return $dao->listarHistoricoPorGuia($idGuia);
    }

}
