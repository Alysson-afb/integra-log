<?php

class GuiaModel {

    public function getGuiaById($id) {
        require_once 'src/dao/GuiaDAO.php';
        $dao = new GuiaDAO();
        return $dao->getGuiaById($id);
    }

    public function getGuiaByNumero($numeroGuia): array {
        require_once 'src/dao/GuiaDAO.php';
        $dao = new GuiaDAO();
        return $dao->getGuiaByNumero($numeroGuia);
    }

    public function listarGuias($mes = null, $ano = null): array {
        require_once 'src/dao/GuiaDAO.php';
        $dao = new GuiaDAO();
        return $dao->listarGuias($mes, $ano);
    }

    public function existeNumeroGuia($numeroGuia, $idIgnorar = null): bool {
        require_once 'src/dao/GuiaDAO.php';
        $dao = new GuiaDAO();
        return $dao->existeNumeroGuia($numeroGuia, $idIgnorar);
    }

    public function cadastrarGuia($numeroGuia, $dataEmissaoGuia, $destinoGuia, $tipoTransporteGuia, $motoristaGuia, $modalidadeGuia, $pesoGuia, $valorFrete, $statusGuia): bool {
        require_once 'src/dao/GuiaDAO.php';
        $dao = new GuiaDAO();
        return $dao->cadastrarGuia($numeroGuia, $dataEmissaoGuia, $destinoGuia, $tipoTransporteGuia, $motoristaGuia, $modalidadeGuia, $pesoGuia, $valorFrete, $statusGuia);
    }

    public function editarGuia($idGuia, $numeroGuia, $dataEmissaoGuia, $destinoGuia, $tipoTransporteGuia, $motoristaGuia, $modalidadeGuia, $pesoGuia, $valorFrete, $statusGuia): bool {
        require_once 'src/dao/GuiaDAO.php';
        $dao = new GuiaDAO();
        return $dao->editarGuia($idGuia, $numeroGuia, $dataEmissaoGuia, $destinoGuia, $tipoTransporteGuia, $motoristaGuia, $modalidadeGuia, $pesoGuia, $valorFrete, $statusGuia);
    }

    public function excluirGuia($id): bool {
        require_once 'src/dao/GuiaDAO.php';
        $dao = new GuiaDAO();
        return $dao->excluirGuia($id);

    }

    public function atualizarStatus($id, $status): bool {
        require_once 'src/dao/GuiaDAO.php';
        $dao = new GuiaDAO();
        return $dao->atualizarStatus($id, $status);
    }

}
