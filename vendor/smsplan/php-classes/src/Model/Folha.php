<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;
use SMSPlan\Helpers\Pager;
use SMSPlan\Helpers\SimpleXLSX;

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
            $pesq = '%' . $search . '%';
            $pesq = "WHERE (CentroCusto LIKE '" . $pesq . "' or Evento LIKE '" . $pesq . "' or Descricao LIKE '" . $pesq . "') ";
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



        $Pager = new Pager('/folha?' . 'Ano=' . $Ano . '&Mes=' . $Mes . '&CC=' . $Cc . '&search=' . $search . '&page=', $resultTotal[0]['nrtotal']);
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

    public function importaplanilha($c_id = null) {
        $read = new Read;
        $read->FullRead('SELECT importa_arquivo FROM c_importa_arquivos where importaid=' . $c_id);
        $impfolha = $read->getResult()[0];
        $linha = 0;
        $linhae = 0;
        $linhad = 0;
        $erro = 0;
        $Create = new Create;

        $centrocutos = new Read;
        $itemcc = new Read;

        $path = '../uploads/' . $impfolha['importa_arquivo'];

        if ($xlsx = SimpleXLSX::parse($path)) {
            echo "<div class='row'>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-striped table-bordered table-hover'>";
            echo "<tbody>";

            foreach ($xlsx->rows() as $r) {
                if ($linha > 0) {
                    if ($this->BuscaDuplicado($r, $linha)) {
                        $erro = 0;
                        $centrocutos->FullRead("SELECT depara_valorDestino FROM c_tabdepara where depara_tabela='folha' AND depara_campotabela='Id_CentroCusto' and depara_valorOrigem=:id", "id={$r[0]}");
                        $info1 = $centrocutos->getResult()[0];
                        if (empty($info1['depara_valorDestino'])) {
                            $erro = 1;
                            echo "<tr>";
                            echo "<td>";
                            echo "Centro de Custo não encontrado na Linha:" . $linha;
                            echo "</td>";

                            echo "<td>";
                            echo "Centro Custo: " . $r[0];
                            echo "</td>";
                            echo "</tr>";
                        }
                        $itemcc->FullRead("SELECT depara_valorDestino, depara_valorDestino FROM c_tabdepara where depara_tabela='folha' AND depara_campotabela='id_ItemCC' and depara_valorOrigem=:id", "id={$r[2]}");
                        $info2 = $itemcc->getResult()[0];
                        if (empty($info2['depara_valorDestino'])) {
                            $erro = 1;
                            echo "<tr>";
                            echo "<td>";
                            echo "Evento não encontrado na Linha:" . $linha;
                            echo "</td>";

                            echo "<td>";
                            echo "Evento: " . $r[2];
                            echo "</td>";
                            echo "</tr>";
                        }
                        if ($erro == 1)
                            $linhae++;
                        if ($erro == 0) {
                            $grava = new Create;
                            $Dados = array(
                                "Ano" => $r[6],
                                "Mes" => $r[7],
                                "Id_CentroCusto" => $info1['depara_valorDestino'],
                                "CentroCusto" => $r[0],
                                "Evento" => $r[1],
                                "Descricao" => $r[2],
                                "Ccusto" => $r[3],
                                "Qtd" => $r[4],
                                "Valor" => $r[5],
                                "id_ItemCC" => $info2['depara_valorDestino']
                            );
                            $grava->ExeCreate('c_folha', $Dados);
                        }
                    } else {
                        $linhad++;
                        echo "<tr>";
                        echo "<td>";
                        echo "Linha Duplicada:" . $linha;
                        echo "</td>";
                        echo "<td>";
                        echo "Ano: " . $r[6];
                        echo "</td>";
                        echo "<td>";
                        echo "Mes: " . $r[7];
                        echo "</td>";
                        echo "<td>";
                        echo "CentroCusto: " . $r[0];
                        echo "</td>";
                        echo "<td>";
                        echo "Evento: " . $r[1];
                        echo "</td>";
                        echo "<td>";
                        echo "Descricao: " . $r[2];
                        echo "</td>";
                        echo "<td>";
                        echo "Ccusto: " . $r[3];
                        echo "</td>";
                        echo "<td>";
                        echo "Qtd: " . $r[4];
                        echo "</td>";
                        echo "<td>";
                        echo "Valor: " . $r[5];
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                $linha++;
            }
            echo "</tbody>";
            echo '</table>';
            echo '</div>';
            echo '</div>';
            $this->Result = TRUE;
        } else {
            $this->Error = ["Erro ao Importar provavel caminho errado " . $path, WS_ALERT];
            $this->Result = FALSE;
        }
        echo "<h2>Resumo de Importação</h2>";
        echo "Linhas Lidas: " . ($linha - 1) . "<br>";
        echo "Linhas com Erro: " . $linhae . "<br>";
        echo "Linhas Duplicadas: " . $linhad . "<br>";
        echo "Linhas Importadas: " . ($linha - 1 - $linhae - $linhad) . "<br>";
    }

}

?>