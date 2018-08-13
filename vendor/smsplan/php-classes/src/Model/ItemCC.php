<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;

class ItemCC extends Model {

    const SESSION_ERROR = "ItemCCError";

    public static function listAll() {

        $sql = new Sql();

        return $sql->select("SELECT *
                            FROM c_tabitemcc
                            ORDER BY Ordem, idItemCC
                    ");
    }

    public function buscaDescricao($DescItemCC) {

        $sql = new Sql();

        return $results = $sql->select("SELECT DescItemCC FROM c_tabitemcc WHERE DescItemCC = :DescItemCC", array(
            ":DescItemCC" => $DescItemCC
        ));
    }

    public function buscaMovCusto($idItemCC) {

        $sql = new Sql();

        return $results = $sql->select("SELECT id_ItemCC FROM c_movcusto WHERE id_ItemCC = :idItemCC LIMIT 1", array(
            ":idItemCC" => $idItemCC
        ));
    }

    public function save() {

        $sql = new Sql();

        $results = $sql->select("CALL sp_tabitemcc_save(:idItemCC, :DescItemCC, :id_GrupoItemCC, :Ordem, :ConteudoItemCC)", array(
            ":idItemCC" => $this->getidItemCC(),
            ":DescItemCC" => $this->getDescItemCC(),
            ":id_GrupoItemCC" => $this->getid_GrupoItemCC(),
            ":Ordem" => $this->getOrdem(),
            ":ConteudoItemCC" => $this->getConteudoItemCC()
        ));

        $this->setData($results[0]);

        $id = $this->getidItemCC();
        $ordem = $this->getOrdem();
        $id_GrupoItemCC = $this->getid_GrupoItemCC();

        $results = $sql->select("SELECT Ordem from c_tabitemcc WHERE id_GrupoItemCC = {$id_GrupoItemCC} AND Ordem = {$ordem} AND idItemCC <> {$id}");

        if (count($results) > 0) {
            $results = $sql->select("SELECT Ordem from c_tabitemcc WHERE id_GrupoItemCC = {$id_GrupoItemCC} AND Ordem = {$ordem}+1 AND idItemCC <> {$id}");
            if (count($results) > 0) {
                $results = $sql->query("UPDATE c_tabitemcc SET Ordem = Ordem+1 WHERE id_GrupoItemCC = {$id_GrupoItemCC} AND Ordem >= {$ordem} AND idItemCC <> {$id}");
            } else {
                $results = $sql->query("UPDATE c_tabitemcc SET Ordem = Ordem+1 WHERE id_GrupoItemCC = {$id_GrupoItemCC} AND Ordem = {$ordem} AND idItemCC <> {$id}");
            }
        }
    }

    public function get($idItemCC) {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM c_tabitemcc WHERE idItemCC = :idItemCC", array(
            ":idItemCC" => $idItemCC
        ));

        $this->setData($results[0]);
    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM c_tabitemcc WHERE idItemCC = :idItemCC", array(
            ":idItemCC" => $this->getidItemCC()
        ));
    }

    public static function getPage($page = 1, $itensPerPage = 10) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $results = $sql->select("
                        SELECT SQL_CALC_FOUND_ROWS
                        a.idItemCC, a.DescItemCC,
                        a.id_GrupoItemCC, b.DescGrupoItemCC,
                        a.Ordem, a.ConteudoItemCC
                        FROM c_tabitemcc a
                        INNER JOIN c_tabgrupoitemcc b ON idGrupoItemCC=a.id_GrupoItemCC
                        ORDER BY id_GrupoItemCC, Ordem, idItemCC
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
                        a.idItemCC, a.DescItemCC,
                        a.id_GrupoItemCC, b.DescGrupoItemCC,
                        a.Ordem, a.ConteudoItemCC
                        FROM c_tabitemcc a
                        INNER JOIN c_tabgrupoitemcc b ON idGrupoItemCC=a.id_GrupoItemCC
			WHERE DescItemCC LIKE :search or ConteudoItemCC LIKE :search
                        ORDER BY id_GrupoItemCC, Ordem, idItemCC
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

        $_SESSION[ItemCC::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {

        $msg = (isset($_SESSION[ItemCC::SESSION_ERROR])) ? $_SESSION[ItemCC::SESSION_ERROR] : "";

        ItemCC::clearMsgError();

        return $msg;
    }

    public static function clearMsgError() {

        $_SESSION[ItemCC::SESSION_ERROR] = NULL;
    }

}

?>