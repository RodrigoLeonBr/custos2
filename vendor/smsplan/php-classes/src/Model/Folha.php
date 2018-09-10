<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;
use SMSPlan\Helpers\Pager;

class Folha extends Model {

    const SESSION_ERROR = "FolhaError";

    public static function listAll() {

        $sql = new Sql();

        return $sql->select("SELECT *
                            FROM c_folha
                            ORDER BY Ano, Mes, Id_CentroCusto, id_ItemCC, Evento
                    ");
    }

    public function save() {

        $sql = new Sql();

        $results = $sql->select("CALL sp_folha_save(:idFolha, :Ano, :Mes, :id_CentroCusto, :CentroCusto, :Evento, :Descricao, :Ccusto, :Qtd, :Valor, :id_ItemCC)", array(
            ":idFolha" => $this->getidFolha(),
            ":Ano" => $this->getAno(),
            ":Mes" => $this->getMes(),
            ":id_CentroCusto" => $this->getid_CentroCusto(),
            ":CentroCusto" => $this->getCentroCusto(),
            ":Evento" => $this->getEvento(),
            ":Descricao" => $this->getDescricao(),
            ":Ccusto" => $this->getCcusto(),
            ":Qtd" => $this->getQtd(),
            ":Valor" => $this->getValor(),
            ":id_ItemCC" => $this->getid_ItemCC()
        ));

        $this->setData($results[0]);
    }

    public function get($idFolha) {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM c_folha WHERE idFolha = :idFolha", array(
            ":idFolha" => $idFolha
        ));

        $this->setData($results[0]);
    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM c_folha WHERE idFolha = :idFolha", array(
            ":idFolha" => $this->getidFolha()
        ));
    }

    public function buscaMovCusto($idFolha) {

        $sql = new Sql();

        $this->get($idFolha);
        $Ano = $this->getAno();
        $Mes = $this->getMes();
        $CC = $this->getid_CentroCusto();
        $itemCC = $this->id_ItemCC();

        return $results = $sql->select("SELECT idCusto FROM c_movcusto WHERE Ano = :Ano "
                . "AND Mes = :Mes AND id_CentroCUsto = :id_CentroCUsto AND id_ItemCC = :id_ItemCC LIMIT 1", array(
            ":Ano" => $Ano,
            ":Mes" => $Mes,
            ":id_CentroCUsto" => $CC,
            ":id_ItemCC" => $itemCC
        ));
    }

    public static function getPage($page = 1, $itensPerPage = 10, $search = '', $Ano = 0, $Mes = 0, $Cc = 0) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $pesq = "";

        if ($search <> '') {
            $search = '%' . $search . '%';
            $pesq = "WHERE (CentroCusto LIKE '" . $search . "' or Evento LIKE '" . $search . "' or Descricao LIKE '" . $search . "') ";
        }

        if (($Ano + $Mes + $Cc) > 0) {
            if ($Ano > 0) {
                if ($pesq == "") {
                    $pesq = 'WHERE Ano =' . $Ano;
                } else {
                    $pesq .= ' AND Ano =' . $Ano;
                }
            }
            if ($Mes > 0) {
                if ($pesq == "") {
                    $pesq = 'WHERE Mes =' . $Mes;
                } else {
                    $pesq .= ' AND Mes =' . $Mes;
                }
            }
            if ($Cc > 0) {
                if ($pesq == "") {
                    $pesq = 'WHERE id_CentroCusto =' . $Cc;
                } else {
                    $pesq .= ' AND id_CentroCusto =' . $Cc;
                }
            }
        }

        $results = $sql->select("
                        SELECT SQL_CALC_FOUND_ROWS
                        a.*,
                        b.DescItemCC
                        FROM c_folha a
                        INNER JOIN c_tabitemcc b ON a.id_ItemCC = b.idItemCC " .
                $pesq .
                " ORDER BY Ano, Mes, Id_CentroCusto, id_ItemCC, Evento
                        LIMIT $start, $itensPerPage;
                        ");

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;
                        ");



        $Pager = new Pager('/folha?' . $search . 'page=', $resultTotal[0]['nrtotal']);
        $Pager->Exepager($page, $itensPerPage);
        $Pager->ExePaginator();

        return [
            'data' => $results,
            'total' => (int) $resultTotal[0]["nrtotal"],
            'pages' => $Pager->getPaginator()
        ];
    }

    public static function getPageSearch(
    $search, $page = 1, $itensPerPage = 10) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        $results = $sql->select("
                        SELECT SQL_CALC_FOUND_ROWS
                        a.*,
                        b.DescItemCC
                        FROM c_folha a
                        INNER JOIN c_tabitemcc b ON a.id_ItemCC = b.idItemCC
                        WHERE CentroCusto LIKE :search or Evento LIKE :search or Descricao LIKE :search
                        ORDER BY Ano, Mes, Id_CentroCusto, id_ItemCC, Evento
                        LIMIT $start, $itensPerPage;
                        ", [
            ':search' => '%' . $search . '%'
        ]);

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;
                        ");

        return [
            'data' => $results,
            'total' => (int) $resultTotal[0]["nrtotal"],
            'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPerPage)
        ];
    }

    public static function setMsgError(
    $msg) {

        $_SESSION[Folha::SESSION_ERROR] = $msg

        ;
    }

    public static function getMsgError() {

        $msg = (isset($_SESSION[Folha::SESSION_ERROR])) ? $_SESSION[Folha::SESSION_ERROR] : "";

        Folha::clearMsgError();

        return $msg;
    }

    public static function clearMsgError() {

        $_SESSION[Folha::SESSION_ERROR] = NULL;
    }

}

?>