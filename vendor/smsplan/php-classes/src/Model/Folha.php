<?php

namespace SMSPlan\Model;

use SMSPlan\DB\Sql;
use SMSPlan\Model;
use SMSPlan\Helpers\Pager;
use SMSPlan\Helpers\Upload;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

    public function importaExcel($arquivo = NULL) {

        $upload = new Upload();
        $upload->Excel($arquivo['importa_arquivo'], $arquivo['importa_tabela']);

        if ($upload->getResult() === FALSE) {
            $this->setMsgError("Erro ao Importar arquivo!");
            return FALSE;
        }

        $result = $this->gravaImportaExcel('uploads/' . $upload->getResult(), $arquivo['importa_tabela'], $arquivo['importa_ano'], $arquivo['importa_mes']);

        if (count($result) == 0) {
            $this->setMsgError("Erro ao gravar arquivo no Banco de Dados!");
            return FALSE;
        }

        $this->importaplanilha($result[0]['importaid']);

        return $upload->getResult();
    }

    private function gravaImportaExcel($local, $nomeArquivo, $ano, $mes) {
        $sql = new Sql();

        $results = $sql->select("
                        CALL sp_importa_arquivos_create(:importa_tabela, :importa_arquivo, :importa_date,
                        :importa_ano, :importa_mes)", [
            ':importa_tabela' => 'folha',
            ':importa_arquivo' => $local,
            ':importa_date' => date("Y-m-d H:i:s"),
            ':importa_ano' => $ano,
            ':importa_mes' => $mes
        ]);

        return $results;
    }

    public function importaplanilha($c_id = null) {
        ini_set('max_execution_time', 300);
        $read = new Sql();
        $result = $read->Select('SELECT * FROM c_importa_arquivos where importaid=' . $c_id);

        $linha = 0;
        $linhae = 0;
        $linhad = 0;
        $erro = 0;

        $centrocutos = new Sql();
        $Create = new Sql();
        $itemcc = new Sql();
        $grava = new Folha();
        //$Create = new Create;
        //$centrocutos = new Read;
        //$itemcc = new Read;


        $spreadsheet = IOFactory::load($result[0]['importa_arquivo']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        echo "<div class='row'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-bordered table-hover'>";
        echo "<tbody>";

        foreach ($sheetData as $r) {

            if ($linha > 0) {

                if ($r['G'] <> $result[0]['importa_ano']) {
                    continue;
                }
                if ($r['H'] <> $result[0]['importa_mes']) {
                    continue;
                }


                if ($this->BuscaDuplicado($r, $linha)) {
                    $erro = 0;
                    $info1 = $centrocutos->Select("SELECT depara_valorDestino FROM c_tabdepara where depara_tabela='folha' AND depara_campotabela='Id_CentroCusto' and depara_valorOrigem=:id", [
                        ":id" => $r['A']
                    ]);

                    if (count($info1) == 0) {

                        $erro = 1;
                        echo "<tr>";
                        echo "<td>";
                        echo "Centro de Custo não encontrado na Linha:" . ($linha + 1);
                        echo "</td>";

                        echo "<td>";
                        echo "Centro Custo: " . $r['A'];
                        echo "</td>";
                        echo "</tr>";
                    }
                    $info2 = $itemcc->select("SELECT depara_valorDestino, depara_valorDestino FROM c_tabdepara where depara_tabela='folha' AND depara_campotabela='id_ItemCC' and depara_valorOrigem=:id", [
                        ":id" => $r['C']
                    ]);

                    if (count($info2) == 0) {
                        $erro = 1;
                        echo "<tr>";
                        echo "<td>";
                        echo "Evento não encontrado na Linha:" . ($linha + 1);
                        echo "</td>";

                        echo "<td>";
                        echo "Evento: " . $r['C'];
                        echo "</td>";
                        echo "</tr>";
                    }
                    if ($erro == 1)
                        $linhae++;
                    if ($erro == 0) {

                        $Dados = array(
                            "idFolha" => 0,
                            "Ano" => $r['G'],
                            "Mes" => $r['H'],
                            "id_CentroCusto" => $info1[0]['depara_valorDestino'],
                            "CentroCusto" => $r['A'],
                            "Evento" => $r['B'],
                            "Descricao" => $r['C'],
                            "Ccusto" => $r['D'],
                            "Qtd" => $r['E'],
                            "Valor" => $r['F'],
                            "id_ItemCC" => $info2[0]['depara_valorDestino']
                        );
                        $grava->setData($Dados);
                        $grava->save();
                    }
                } else {
                    $linhad++;
                    echo "<tr>";
                    echo "<td>";
                    echo "Linha Duplicada:" . $linha;
                    echo "</td>";
                    echo "<td>";
                    echo "Ano: " . $r['G'];
                    echo "</td>";
                    echo "<td>";
                    echo "Mes: " . $r['H'];
                    echo "</td>";
                    echo "<td>";
                    echo "CentroCusto: " . $r['A'];
                    echo "</td>";
                    echo "<td>";
                    echo "Evento: " . $r['B'];
                    echo "</td>";
                    echo "<td>";
                    echo "Descricao: " . $r['C'];
                    echo "</td>";
                    echo "<td>";
                    echo "Ccusto: " . $r['D'];
                    echo "</td>";
                    echo "<td>";
                    echo "Qtd: " . $r['E'];
                    echo "</td>";
                    echo "<td>";
                    echo "Valor: " . $r['F'];
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

        echo "<h2>Resumo de Importação</h2>";
        echo "Linhas Lidas: " . ($linha - 1) . "<br>";
        echo "Linhas com Erro: " . $linhae . "<br>";
        echo "Linhas Duplicadas: " . $linhad . "<br>";
        echo "Linhas Importadas: " . ($linha - 1 - $linhae - $linhad) . "<br>";
    }

    private function BuscaDuplicado($busca, $l) {
        if (!empty($busca)):
            $busca['A'] = addslashes($busca['A']);
            $busca['C'] = addslashes($busca['C']);
            $read = new Sql();
            $Termos = "SELECT IdFolha FROM c_folha ";
            $Termos .= " WHERE Ano = \"" . $busca['G'] . "\" and Mes=\"" . $busca['H'] . "\" ";
            $Termos .= " and CentroCusto = \"" . $busca['A'] . "\" and Descricao = \"" . $busca['C'] . "\" ";
            $result = $read->select($Termos);
            if (count($result) > 0) {
                return FALSE;
            } else {
                return TRUE;
            }
        else :
            $l = $l + 1;
            $this->Error .= "<td><tr>Linha do Excel {$l} em Branco </td></tr>";
            return FALSE;
        endif;
    }

}

?>