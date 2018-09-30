<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;
use SMSPlan\Helpers\Check;

class Contrato extends Model {

    const SESSION_ERROR = "ContratoError";

    private $Data;
    private $CId;
    private $Error;
    private $Result;

    public static function listAll($status = 1) {

        if ($status == 2) {
            $status = '';
        } else {
            $status = 'WHERE Contrato_Status = ' . $status;
        }

        $sql = new Sql();

        return $sql->select("SELECT *
                            FROM c_contrato
                            {$status}
                            ORDER BY Desc Contrato_Status, Contrato_Vencimento, idContrato
                    ");
    }

    public function buscaProtocolo($Contrato_Protocolo) {

        $sql = new Sql();

        return $results = $sql->select("SELECT Contrato_Protocolo FROM c_contrato WHERE Contrato_Protocolo = :Contrato_Protocolo", array(
            ":Contrato_Protocolo" => $Contrato_Protocolo
        ));
    }

    public function buscaLancamento($idContrato) {

        $sql = new Sql();

        return $results = $sql->select("SELECT id_Contrato FROM c_contrato_lancamento WHERE id_Contrato = :idContrato", array(
            ":id_Contrato" => $idContrato
        ));
    }

    public function save() {

        $sql = new Sql();

        $this->checkData();

        $results = $sql->select("INSERT INTO c_contrato (
                Contrato_Protocolo , Contrato_Historico ,
		Contrato_Objeto , Contrato_Obs ,
		Contrato_Cnes ,Contrato_Prestador ,
		Contrato_Cnpj ,	Contrato_Data ,
		Contrato_Vencimento , Contrato_Valor ,
		Contrato_Qtd , Contrato_Saldovalor ,
		Contrato_Saldoqtd , Contrato_Status )
        VALUES ( :Contrato_Protocolo ,:Contrato_Historico ,
		:Contrato_Objeto ,:Contrato_Obs ,
		:Contrato_Cnes ,:Contrato_Prestador ,
		:Contrato_Cnpj ,:Contrato_Data ,
		:Contrato_Vencimento ,:Contrato_Valor ,
		:Contrato_Qtd ,:Contrato_Saldovalor ,
		:Contrato_Saldoqtd ,:Contrato_Status );", array(
            ":Contrato_Protocolo" => $this->getContrato_Protocolo(),
            ":Contrato_Historico" => $this->getContrato_Historico(),
            ":Contrato_Objeto" => $this->getContrato_Objeto(),
            ":Contrato_Obs" => $this->getContrato_Obs(),
            ":Contrato_Cnes" => $this->getContrato_Cnes(),
            ":Contrato_Prestador" => $this->getContrato_Prestador(),
            ":Contrato_Cnpj" => $this->getContrato_Cnpj(),
            ":Contrato_Data" => $this->getContrato_Data(),
            ":Contrato_Vencimento" => $this->getContrato_Vencimento(),
            ":Contrato_Valor" => $this->getContrato_Valor(),
            ":Contrato_Qtd" => $this->getContrato_Qtd(),
            ":Contrato_Saldovalor" => $this->getContrato_Saldovalor(),
            ":Contrato_Saldoqtd" => $this->getContrato_Saldoqtd(),
            ":Contrato_Status" => $this->getContrato_Status()
        ));
    }

    public function get($idContrato) {

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM c_contrato WHERE idContrato = :idContrato", array(
            ":idContrato" => $idContrato
        ));

        $this->setData($results[0]);
    }

    public function delete() {

        $sql = new Sql();

        $sql->query("DELETE FROM c_contrato WHERE idContrato = :idContrato", array(
            ":idContrato" => $this->getidContrato()
        ));
    }

    public function addItem(ItemCC $itemCC) {

        $sql = new Sql();

        $sql->query("UPDATE c_tabitemcc SET id_GrupoItemCC = :id_GrupoItemCC WHERE idItemCC = :idItemCC", [
            ":id_GrupoItemCC" => $this->getidGrupoItemCC(),
            ":idItemCC" => $itemCC->getidItemCC()
        ]);
    }

    public static function getPage($page = 1, $itensPerPage = 10, $status = 1) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        if ($status == 2) {
            $status = '';
        } else {
            $status = 'WHERE a.Contrato_Status = ' . $status;
        }

        $results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS
                        a.idContrato, a.Contrato_Protocolo, a.Contrato_Cnes, a.Contrato_Prestador,
                        a.Contrato_Vencimento, a.Contrato_Data, a.Contrato_Valor, a.Contrato_Qtd,
                        a.Contrato_Saldovalor, a.Contrato_Saldoqtd, SUBSTRING(a.Contrato_Obs,1,60) Obs,
                        a.Contrato_Status, count(b.Id_Contrato) lanc, 1 id,
                        DATEDIFF(a.Contrato_Vencimento, a.Contrato_Data) DifData,
                        TIMESTAMPDIFF(month, curdate(), a.Contrato_Vencimento) DifVenc
                        FROM c_contrato a
                        LEFT JOIN c_contrato_lancamento b on idContrato=Id_Contrato {$status}
                        GROUP BY a.Contrato_Status, a.Contrato_Vencimento, a.idContrato
                        ORDER BY a.Contrato_Status, a.Contrato_Vencimento, a.idContrato
			LIMIT $start, $itensPerPage;
			");

        $resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        return [
            'data' => $results,
            'total' => (int) $resultTotal[0]["nrtotal"],
            'pages' => ceil($resultTotal[0]["nrtotal"] / $itensPerPage)
        ];
    }

    public static function getPageSearch($search, $page = 1, $itensPerPage = 10, $status = 1) {

        $start = ($page - 1 ) * $itensPerPage;
        $sql = new Sql();

        if ($status == 2) {
            $status = '';
        } else {
            $status = ' AND a.Contrato_Status = ' . $status;
        }

        $results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS
                        a.idContrato, a.Contrato_Protocolo, a.Contrato_Cnes, a.Contrato_Prestador,
                        a.Contrato_Vencimento, a.Contrato_Data, a.Contrato_Valor, a.Contrato_Qtd,
                        a.Contrato_Saldovalor, a.Contrato_Saldoqtd, SUBSTRING(a.Contrato_Obs,1,60) Obs,
                        a.Contrato_Status, count(b.Id_Contrato) lanc, 1 id,
                        DATEDIFF(a.Contrato_Vencimento, a.Contrato_Data) DifData,
                        TIMESTAMPDIFF(month, curdate(), a.Contrato_Vencimento) DifVenc
                        FROM c_contrato a
                        LEFT JOIN c_contrato_lancamento b on idContrato=Id_Contrato {$status}
			WHERE Contrato_Protocolo LIKE :search or Contrato_Prestador LIKE :search {$status}
                        GROUP BY a.Contrato_Status, a.Contrato_Vencimento, a.idContrato
                        ORDER BY a.Contrato_Status, a.Contrato_Vencimento, a.idContrato
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

    public function getLanc($related = true) {

        $sql = new Sql();

        if ($related === true) {

            return $sql->select("
			SELECT * FROM c_contrato_lancamento WHERE Id_Contrato = :idContrato
			", [
                        ':idContrato' => $this->getidContrato()
            ]);
        } else {

            return $sql->select("
			SELECT * FROM c_contrato_lancamento WHERE Id_Contrato <> :idContrato
			", [
                        ':idContrato' => $this->getidContrato()
            ]);
        }
    }

    public static function setMsgError($msg) {

        $_SESSION[Contrato::SESSION_ERROR] = $msg;
    }

    public static function getMsgError() {

        $msg = (isset($_SESSION[Contrato::SESSION_ERROR])) ? $_SESSION[Contrato::SESSION_ERROR] : "";

        Contrato::clearMsgError();

        return $msg;
    }

    public static function clearMsgError() {

        $_SESSION[Contrato::SESSION_ERROR] = NULL;
    }

    public function checkData() {
        $source = array('.', ',');
        $replace = array('', '.');

        $valor = str_replace($source, $replace, $this->getContrato_Valor());
        $this->setContrato_Valor(floatval($valor));
        $valor = str_replace($source, $replace, $this->getContrato_Qtd());
        $this->setContrato_Qtd(floatval($valor));

        $this->setContrato_Data(Check::Data($this->getContrato_Data()));
        $this->setContrato_Vencimento(Check::Data($this->getContrato_Vencimento()));

        $this->setContrato_Saldovalor($this->getContrato_Valor());
        $this->setContrato_Saldoqtd($this->getContrato_Qtd());

        $this->setidContrato($this->getidContrato());
    }

}
?>;