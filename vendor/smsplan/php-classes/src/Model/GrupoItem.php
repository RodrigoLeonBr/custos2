<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;

class GrupoItem extends Model {

    const SESSION_ERROR = "GrupoItemError";

    public static function listAll() {

        $sql = new Sql();

        return $sql->select("SELECT idGrupoItemCC, DescGrupoItemCC, Ordem
                            FROM c_tabgrupoitemcc
                            ORDER BY Ordem
                    ");
    }

    public static function maxOrdem() {

        $sql = new Sql();

        return $sql->select("SELECT (MAX(Ordem)+1) as maxordem FROM c_tabgrupoitemcc ");
    }

    public function buscaDescricao($DescGrupoItemCC) {

        $sql = new Sql();

        return $results = $sql->select("SELECT DescGrupoItemCC FROM c_tabgrupoitemcc WHERE DescGrupoItemCC = :DescGrupoItemCC", array(
            ":DescGrupoItemCC" => $DescGrupoItemCC
        ));
    }

    public function buscaItem($idGrupoItemCC) {

        $sql = new Sql();

        return $results = $sql->select("SELECT id_GrupoItemCC FROM c_tabitemcc WHERE id_GrupoItemCC = :idGrupoItemCC", array(
            ":idGrupoItemCC" => $idGrupoItemCC
        ));
    }

    public function save() {

        $sql = new Sql();

        $results = $sql->select("CALL sp_tabgrupoitemcc_save(:idGrupoItemCC, :DescGrupoItemCC, :Ordem, :GrupoItemConteudo)", array(
            ":idGrupoItemCC" => $this->getidGrupoItemCC(),
            ":DescGrupoItemCC" => $this->getDescGrupoItemCC(),
            ":Ordem" => $this->getOrdem(),
            ":GrupoItemConteudo" => $this->getGrupoItemConteudo()
        ));

        $this->setData($results[0]);
    }

    public function get($idGrupoItemCC) {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM c_tabgrupoitemcc WHERE idGrupoItemCC = :idGrupoItemCC", array(
            ":idGrupoItemCC" => $idGrupoItemCC
        ));

        $this->setData($results[0]);
    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM c_tabgrupoitemcc WHERE idGrupoItemCC = :idGrupoItemCC", array(
            ":idGrupoItemCC" => $this->getidGrupoItemCC()
        ));
    }

    public function addItem(ItemCC $itemCC) {

        $sql = new Sql();

        $sql->query("UPDATE c_tabitemcc SET id_GrupoItemCC = :id_GrupoItemCC WHERE idItemCC = :idItemCC", [
            ":id_GrupoItemCC" => $this->getidGrupoItemCC(),
            ":idItemCC" => $itemCC->getidItemCC()
        ]);
    }

    public static function getPage($page = 1, $itensPerPage = 10) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS
                        a.idGrupoItemCC, a.DescGrupoItemCC, a.Ordem, a.GrupoItemConteudo, count(b.id_GrupoItemCC) item
                        FROM c_tabgrupoitemcc a
                        LEFT JOIN c_tabitemcc b on idGrupoItemCC=id_GrupoItemCC
                        GROUP BY a.idGrupoItemCC, a.DescGrupoItemCC, a.GrupoItemConteudo, a.Ordem
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
                        a.idGrupoItemCC, a.DescGrupoItemCC, a.Ordem, a.GrupoItemConteudo, count(b.id_GrupoItemCC) item
                        FROM c_tabgrupoitemcc a
                        LEFT JOIN c_tabitemcc b on idGrupoItemCC=id_GrupoItemCC
			WHERE DescGrupoItemCC LIKE :search or GrupoItemConteudo LIKE :search
                        GROUP BY a.idGrupoItemCC, a.DescGrupoItemCC, a.GrupoItemConteudo, a.Ordem
                        ORDER BY a.Ordem
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

    public function getItemCC($related = true) {

        $sql = new Sql();

        if ($related === true) {

            return $sql->select("
			SELECT * FROM c_tabitemcc WHERE id_GrupoItemCC = :idGrupoItemCC
			", [
                        ':idGrupoItemCC' => $this->getidGrupoItemCC()
            ]);
        } else {

            return $sql->select("
				SELECT * FROM c_tabitemcc WHERE id_GrupoItemCC <> :idGrupoItemCC
			", [
                        ':idGrupoItemCC' => $this->getidGrupoItemCC()
            ]);
        }
    }

    public static function setMsgError($msg) {

        $_SESSION[GrupoItem::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {

        $msg = (isset($_SESSION[GrupoItem::SESSION_ERROR])) ? $_SESSION[GrupoItem::SESSION_ERROR] : "";

        GrupoItem::clearMsgError();

        return $msg;
    }

    public static function clearMsgError() {

        $_SESSION[GrupoItem::SESSION_ERROR] = NULL;
    }

}

?>