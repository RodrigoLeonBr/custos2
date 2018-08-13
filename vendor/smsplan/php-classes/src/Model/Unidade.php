<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;

class Unidade extends Model {

    const SESSION_ERROR = "UnidadeError";

    public static function listAll() {

        $sql = new Sql();

        return $sql->select("SELECT idUnidade, UnDescricao
                            FROM c_tabunidade
                            ORDER BY idUnidade
                ");
    }

    public function buscaDescricao($UnDescricao) {

        $sql = new Sql();

        return $results = $sql->select("SELECT UnDescricao FROM c_tabunidade WHERE UnDescricao = :UnDescricao", array(
            ":UnDescricao" => $UnDescricao
        ));
    }

    public function buscaCusto($idUnidade) {

        $sql = new Sql();

        return $results = $sql->select("SELECT idCentroCusto FROM c_tabcentrocusto WHERE id_Unidade = :idUnidade", array(
            ":idUnidade" => $idUnidade
        ));
    }

    public function save() {

        $sql = new Sql();

        $results = $sql->select("CALL sp_tabunidade_save(:idUnidade, :UnDescricao, :UnConteudo)", array(
            ":idUnidade" => $this->getidUnidade(),
            ":UnDescricao" => $this->getUnDescricao(),
            ":UnConteudo" => $this->getUnConteudo()
        ));

        $this->setData($results[0]);
    }

    public function get($idUnidade) {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM c_tabunidade WHERE idUnidade = :idUnidade", array(
            ":idUnidade" => $idUnidade
        ));

        $this->setData($results[0]);
    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM c_tabunidade WHERE idUnidade = :idUnidade", array(
            ":idUnidade" => $this->getidUnidade()
        ));
    }

    public function addCCusto(CCusto $ccusto) {

        $sql = new Sql();

        $sql->query("UPDATE c_tabcentrocusto SET id_Unidade = :id_Unidade WHERE idCentroCusto = :idCentroCusto", [
            ":id_Unidade" => $this->getidUnidade(),
            ":idCentroCusto" => $ccusto->getidCentroCusto()
        ]);
    }

    public static function getPage($page = 1, $itensPerPage = 10) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS
                        a.idUnidade, a.UnDescricao, a.UnConteudo, count(b.id_Unidade) cc
                        FROM c_tabunidade a
                        LEFT JOIN c_tabcentrocusto b on idUnidade=id_Unidade
                        GROUP BY a.idUnidade, a.UnDescricao, a.UnConteudo
                        ORDER BY UnDescricao
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
                        a.idUnidade, a.UnDescricao, a.UnConteudo, count(b.id_Unidade) cc
                        FROM c_tabunidade a
                        LEFT JOIN c_tabcentrocusto b on idUnidade=id_Unidade
			WHERE UnDescricao LIKE :search
                        GROUP BY a.idUnidade, a.UnDescricao, a.UnConteudo
                        ORDER BY UnDescricao
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
				SELECT * FROM c_tabcentrocusto WHERE id_Unidade = :idUnidade
			", [
                        ':idUnidade' => $this->getidUnidade()
            ]);
        } else {

            return $sql->select("
				SELECT * FROM c_tabcentrocusto WHERE id_Unidade <> :idUnidade
			", [
                        ':idUnidade' => $this->getidUnidade()
            ]);
        }
    }

    public static function setMsgError($msg) {

        $_SESSION[Unidade::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {

        $msg = (isset($_SESSION[Unidade::SESSION_ERROR])) ? $_SESSION[Unidade::SESSION_ERROR] : "";

        Unidade::clearMsgError();

        return $msg;
    }

    public static function clearMsgError() {

        $_SESSION[Unidade::SESSION_ERROR] = NULL;
    }

}

?>