<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;

class Grupo extends Model {

    const SESSION_ERROR = "GrupoError";

    public static function listAll() {

        $sql = new Sql();

        return $sql->select("SELECT idGrupoCC, DescGrupoCC, Ordem
                            FROM c_tabgrupocc
                            ORDER BY Ordem
                    ");
    }

    public static function maxOrdem() {

        $sql = new Sql();

        return $sql->select("SELECT (MAX(Ordem)+1) as maxordem FROM c_tabgrupocc ");
    }

    public function buscaDescricao($DescGrupoCC) {

        $sql = new Sql();

        return $results = $sql->select("SELECT DescGrupoCC FROM c_tabgrupocc WHERE DescGrupoCC = :DescGrupoCC", array(
            ":DescGrupoCC" => $DescGrupoCC
        ));
    }

    public function buscaCusto($idGrupoCC) {

        $sql = new Sql();

        return $results = $sql->select("SELECT idCentroCusto FROM c_tabcentrocusto WHERE id_GrupoCC = :idGrupoCC", array(
            ":idGrupoCC" => $idGrupoCC
        ));
    }

    public function save() {

        $sql = new Sql();

        $results = $sql->select("CALL sp_tabgrupocc_save(:idGrupoCC, :DescGrupoCC, :Ordem, :GrupoConteudo)", array(
            ":idGrupoCC" => $this->getidGrupoCC(),
            ":DescGrupoCC" => $this->getDescGrupoCC(),
            ":Ordem" => $this->getOrdem(),
            ":GrupoConteudo" => $this->getGrupoConteudo()
        ));

        $this->setData($results[0]);
    }

    public function get($idGrupoCC) {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM c_tabgrupocc WHERE idGrupoCC = :idGrupoCC", array(
            ":idGrupoCC" => $idGrupoCC
        ));

        $this->setData($results[0]);
    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM c_tabgrupocc WHERE idGrupoCC = :idGrupoCC", array(
            ":idGrupoCC" => $this->getidGrupoCC()
        ));
    }

    public function addCCusto(CCusto $ccusto) {

        $sql = new Sql();

        $sql->query("UPDATE c_tabcentrocusto SET id_GrupoCC = :id_GrupoCC WHERE idCentroCusto = :idCentroCusto", [
            ":id_GrupoCC" => $this->getidGrupoCC(),
            ":idCentroCusto" => $ccusto->getidCentroCusto()
        ]);
    }

    public static function getPage($page = 1, $itensPerPage = 10) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS
                            a.idGrupoCC, a.DescGrupoCC, a.Ordem, a.GrupoConteudo, count(b.id_GrupoCC) cc
                            FROM c_tabgrupocc a
                            LEFT JOIN c_tabcentrocusto b on idGrupoCC=id_GrupoCC
                            GROUP BY a.idGrupoCC, a.DescGrupoCC, a.GrupoConteudo, a.Ordem
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
                        a.idGrupoCC, a.DescGrupoCC, a.Ordem, a.GrupoConteudo, count(b.id_GrupoCC) cc
                        FROM c_tabgrupocc a
                        LEFT JOIN c_tabcentrocusto b on idGrupoCC=id_GrupoCC
			WHERE DescGrupoCC LIKE :search or GrupoConteudo LIKE :search
                        GROUP BY a.idGrupoCC, a.DescGrupoCC, a.GrupoConteudo, a.Ordem
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
				SELECT * FROM c_tabcentrocusto WHERE id_GrupoCC = :idGrupoCC
			", [
                        ':idGrupoCC' => $this->getidGrupoCC()
            ]);
        } else {

            return $sql->select("
				SELECT * FROM c_tabcentrocusto WHERE id_GrupoCC <> :idGrupoCC
			", [
                        ':idGrupoCC' => $this->getidGrupoCC()
            ]);
        }
    }

    public static function setMsgError($msg) {

        $_SESSION[Grupo::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {

        $msg = (isset($_SESSION[Grupo::SESSION_ERROR])) ? $_SESSION[Grupo::SESSION_ERROR] : "";

        Grupo::clearMsgError();

        return $msg;
    }

    public static function clearMsgError() {

        $_SESSION[Grupo::SESSION_ERROR] = NULL;
    }

}

?>