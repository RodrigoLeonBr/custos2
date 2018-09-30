<?php

require 'vendor/autoload.php';

use SMSPlan\Page;
use SMSPlan\Model\User;
use SMSPlan\Model\CCusto;
use SMSPlan\Model\ItemCC;
use SMSPlan\Model\Folha;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$app->get("/folha", function() {

    User::verifyLogin();
    User::setSessao("auxiliar,folha,folha");

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;
    $Ano = (isset($_GET['Ano'])) ? (int) $_GET['Ano'] : 0;
    $Mes = (isset($_GET['Mes'])) ? (int) $_GET['Mes'] : 0;
    $Cc = (isset($_GET['CC'])) ? (int) $_GET['CC'] : 0;

    $pagination = Folha::getPage($page, 50, $search, $Ano, $Mes, $Cc);

    $getPage = $page;

    $page = new Page();

    $page->setTpl("folha", [
        "folha" => $pagination['data'],
        "search" => $search,
        "Ano" => $Ano,
        "Mes" => $Mes,
        "Cc" => $Cc,
        "pages" => $pagination['pages'],
        "error" => Folha::getMsgError()
    ]);
});

$app->get("/folha/create", function() {

    User::verifyLogin();
    User::setSessao("auxiliar,folha,folha");

    $page = new Page();

    $ccusto = CCusto::listAll();
    $itemcc = ItemCC::listAll();

    $page->setTpl("folha-create", [
        "ccusto" => $ccusto,
        "itemcc" => $itemcc,
        "error" => Folha::getMsgError()
    ]);
});

$app->post("/folha/create", function() {

    User::verifyLogin();

    $folha = new Folha();

    $result = new Folha();
    $result = $result->buscaDescricao($_POST['DescCentroCusto']);

    if (count($result) > 0) {

        Folha::setMsgError("C Custo " . $_POST['DescCentroCusto'] . " já Cadastrado!");
        header('Location: /folha/create');
        exit;
    } else {

        $folha->setData($_POST);

        $folha->save();

        header("Location: /folha");
        exit;
    }
});

$app->get("/folha/:idFolha/delete", function($idFolha) {

    User::verifyLogin();

    $folha = new Folha();

    $folha->get((int) $idFolha);

    $result = new Folha();
    $result = $folha->buscaMovCusto($idFolha);

    if (count($result) > 0) {
        Folha::setMsgError("Lançamento possui Movimento Cadastrado. Não é possível excluir: ");
    } else {
        $folha->delete();
    }
    header("Location: /folha");
    exit;
});

$app->get("/folha/:idFolha", function($idFolha) {

    User::verifyLogin();
    User::setSessao("auxiliar,folha,folha");

    $folha = new Folha();

    $folha->get((int) $idFolha);

    $ccusto = CCusto::listAll();
    $itemcc = ItemCC::listAll();

    $page = new Page();

    $page->setTpl("folha-update", [
        "folha" => $folha->getValues(),
        "ccusto" => $ccusto,
        "itemcc" => $itemcc,
        "error" => Folha::getMsgError()
    ]);
});

$app->post("/folha/:idFolha", function($idFolha) {

    User::verifyLogin();

    $folha = new Folha();

    $folha->get((int) $idFolha);

    $folha->setData($_POST);

    $folha->save();

    header("Location: /folha");
    exit;
});

$app->get("/importafolha", function() {

    $inputFileName = 'custos_01_2017.xlsx';
//    //$helper->log('Loading file ' . pathinfo($inputFileName, PATHINFO_BASENAME) . ' using IOFactory to identify the format');
    $spreadsheet = IOFactory::load($inputFileName);
    $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    var_dump($sheetData);
});


