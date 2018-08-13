<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;

class SubGrupo extends Model {

    const SESSION_ERROR = "SubGrupoError";

    public static function listAll() {

        $sql = new Sql();

        return $sql->select("SELECT idSubGrupoCC, DescSubGrupoCC, Ordem
                            FROM c_tabsubgrupocc
                            ORDER BY Ordem
                    ");
    }

    public static function maxOrdem() {

        $sql = new Sql();

        return $sql->select("SELECT (MAX(Ordem)+1) as maxordem FROM c_tabsubgrupocc ");
    }

    public function buscaDescricao($DescSubGrupoCC) {

        $sql = new Sql();

        return $results = $sql->select("SELECT DescSubGrupoCC FROM c_tabsubgrupocc WHERE DescSubGrupoCC = :DescSubGrupoCC", array(
            ":DescSubGrupoCC" => $DescSubGrupoCC
        ));
    }

    public function buscaCusto($idSubGrupoCC) {

        $sql = new Sql();

        return $results = $sql->select("SELECT idCentroCusto FROM c_tabcentrocusto WHERE id_SubGrupoCC = :idSubGrupoCC", array(
            ":idSubGrupoCC" => $idSubGrupoCC
        ));
    }

    public function save() {

        $sql = new Sql();

        $results = $sql->select("CALL sp_tabsubgrupocc_save(:idSubGrupoCC, :DescSubGrupoCC, :Ordem, :SubGrupoConteudo)", array(
            ":idSubGrupoCC" => $this->getidSubGrupoCC(),
            ":DescSubGrupoCC" => $this->getDescSubGrupoCC(),
            ":Ordem" => $this->getOrdem(),
            ":SubGrupoConteudo" => $this->getSubGrupoConteudo()
        ));

        $this->setData($results[0]);
    }

    public function get($idSubGrupoCC) {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM c_tabsubgrupocc WHERE idSubGrupoCC = :idSubGrupoCC", array(
            ":idSubGrupoCC" => $idSubGrupoCC
        ));

        $this->setData($results[0]);
    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM c_tabsubgrupocc WHERE idSubGrupoCC = :idSubGrupoCC", array(
            ":idSubGrupoCC" => $this->getidSubGrupoCC()
        ));
    }

    public function addCCusto(CCusto $ccusto) {

        $sql = new Sql();

        $sql->query("UPDATE c_tabcentrocusto SET id_SubGrupoCC = :id_SubGrupoCC WHERE idCentroCusto = :idCentroCusto", [
            ":id_SubGrupoCC" => $this->getidSubGrupoCC(),
            ":idCentroCusto" => $ccusto->getidCentroCusto()
        ]);
    }

    public static function getPage($page = 1, $itensPerPage = 10) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS
                            a.idSubGrupoCC, a.DescSubGrupoCC, a.Ordem, a.SubGrupoConteudo, count(b.id_SubGrupoCC) cc
                            FROM c_tabsubgrupocc a
                            LEFT JOIN c_tabcentrocusto b on idSubGrupoCC=id_SubGrupoCC
                            GROUP BY a.idSubGrupoCC, a.DescSubGrupoCC, a.SubGrupoConteudo, a.Ordem
                            ORDER BY a.Ordem
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
                        a.idSubGrupoCC, a.DescSubGrupoCC, a.Ordem, a.SubGrupoConteudo, count(b.id_SubGrupoCC) cc
                        FROM c_tabsubgrupocc a
                        LEFT JOIN c_tabcentrocusto b on idSubGrupoCC=id_SubGrupoCC
			WHERE DescSubGrupoCC LIKE :search or SubGrupoConteudo LIKE :search
                        GROUP BY a.idSubGrupoCC, a.DescSubGrupoCC, a.SubGrupoConteudo, a.Ordem
			ORDER BY Ordem
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

    public function getCcustos($related = true) {

        $sql = new Sql();

        if ($related === true) {

            return $sql->select("
				SELECT * FROM c_tabcentrocusto WHERE id_SubGrupoCC = :idSubGrupoCC
			", [
                        ':idSubGrupoCC' => $this->getidSubGrupoCC()
            ]);
        } else {

            return $sql->select("
				SELECT * FROM c_tabcentrocusto WHERE id_SubGrupoCC <> :idSubGrupoCC
			", [
                        ':idSubGrupoCC' => $this->getidSubGrupoCC()
            ]);
        }
    }

    public static function setMsgError($msg) {

        $_SESSION[SubGrupo::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {

        $msg = (isset($_SESSION[SubGrupo::SESSION_ERROR])) ? $_SESSION[SubGrupo::SESSION_ERROR] : "";

        SubGrupo::clearMsgError();

        return $msg;
    }

    public static function clearMsgError() {

        $_SESSION[SubGrupo::SESSION_ERROR] = NULL;
    }

}

?>