<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;

class CCusto extends Model {

    const SESSION_ERROR = "CCustoError";

    public static function listAll() {

        $sql = new Sql();

        return $sql->select("SELECT *
                            FROM c_tabcentrocusto
                            ORDER BY id_Unidade, id_GrupoCC, id_SubGrupoCC, idCentroCusto
                    ");
    }

    public function buscaDescricao($DescCentroCusto) {

        $sql = new Sql();

        return $results = $sql->select("SELECT DescCentroCusto FROM c_tabcentrocusto WHERE DescCentroCusto = :DescCentroCusto", array(
            ":DescCentroCusto" => $DescCentroCusto
        ));
    }

    public function buscaMovCusto($idCentroCusto) {

        $sql = new Sql();

        return $results = $sql->select("SELECT id_CentroCusto FROM c_movcusto WHERE id_CentroCusto = :idCentroCusto LIMIT 1", array(
            ":idCentroCusto" => $idCentroCusto
        ));
    }

    public function save() {

        $sql = new Sql();

        $results = $sql->select("CALL sp_tabccusto_save(:idCentroCusto, :DescCentroCusto, :id_Unidade, :id_GrupoCC, :id_SubGrupoCC, :TipoCC, :StatusCC, :ConteudoCentroCusto)", array(
            ":idCentroCusto" => $this->getidCentroCusto(),
            ":DescCentroCusto" => $this->getDescCentroCusto(),
            ":id_Unidade" => $this->getid_Unidade(),
            ":id_GrupoCC" => $this->getid_GrupoCC(),
            ":id_SubGrupoCC" => $this->getid_SubGrupoCC(),
            ":TipoCC" => $this->getTipoCC(),
            ":StatusCC" => $this->getStatusCC(),
            ":ConteudoCentroCusto" => $this->getConteudoCentroCusto()
        ));

        $this->setData($results[0]);
    }

    public function get($idCentroCusto) {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM c_tabcentrocusto WHERE idCentroCusto = :idCentroCusto", array(
            ":idCentroCusto" => $idCentroCusto
        ));

        $this->setData($results[0]);
    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM c_tabcentrocusto WHERE idCentroCusto = :idCentroCusto", array(
            ":idCentroCusto" => $this->getidCentroCusto()
        ));
    }

    public static function getPage($page = 1, $itensPerPage = 10) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS
                        a.idCentroCusto, a.DescCentroCusto,
                        a.id_Unidade, b.UnDescricao,
                        a.id_GrupoCC, c.DescGrupoCC,
                        a.id_SubGrupoCC, d.DescSubGrupoCC,
                        a.TipoCC, a.StatusCC, a.ConteudoCentroCusto
                        FROM c_tabcentrocusto a
                        INNER JOIN c_tabunidade b ON idUnidade=a.id_Unidade
                        INNER JOIN c_tabgrupocc c ON idGrupoCC=a.id_GrupoCC
                        INNER JOIN c_tabsubgrupocc d ON idSubGrupoCC=a.id_SubGrupoCC
                        ORDER BY id_Unidade, id_GrupoCC, id_SubGrupoCC, idCentroCusto
			LIMIT $start, $itensPerPage;
			");

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        return [
            'data' => $results,
            'total' => (int) $resultTotal[0]["nrtotal"],
            'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPerPage)
        ];
    }

    public static function getPageSearch($search, $page = 1, $itensPerPage = 10) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS
                        a.idCentroCusto, a.DescCentroCusto,
                        a.id_Unidade, b.UnDescricao,
                        a.id_GrupoCC, c.DescGrupoCC,
                        a.id_SubGrupoCC, d.DescSubGrupoCC,
                        a.TipoCC, a.StatusCC, a.ConteudoCentroCusto
                        FROM c_tabcentrocusto a
                        INNER JOIN c_tabunidade b ON idUnidade=a.id_Unidade
                        INNER JOIN c_tabgrupocc c ON idGrupoCC=a.id_GrupoCC
                        INNER JOIN c_tabsubgrupocc d ON idSubGrupoCC=a.id_SubGrupoCC
			WHERE DescCentroCusto LIKE :search or ConteudoCentroCusto LIKE :search
                        ORDER BY id_Unidade, id_GrupoCC, id_SubGrupoCC, idCentroCusto
			LIMIT $start, $itensPerPage;
			", [
            ':search' => '%' . $search . '%'
        ]);

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        return [
            'data' => $results,
            'total' => (int) $resultTotal[0]["nrtotal"],
            'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPerPage)
        ];
    }

    public static function setMsgError($msg) {

        $_SESSION[CCusto::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {

        $msg = (isset($_SESSION[CCusto::SESSION_ERROR])) ? $_SESSION[CCusto::SESSION_ERROR] : "";

        CCusto::clearMsgError();

        return $msg;
    }

    public static function clearMsgError() {

        $_SESSION[CCusto::SESSION_ERROR] = NULL;
    }

}

?>