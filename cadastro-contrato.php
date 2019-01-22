<?php

use SMSPlan\Page;
use SMSPlan\Model\User;
use SMSPlan\Model\Contrato;

$app->get("/contratos", function() {

    User::verifyLogin();
    User::setSessao("contratos,contratos,");

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

    if ($search != '') {

        $pagination = Contrato::getPageSearch($search, $page);
    } else {

        $pagination = Contrato::getPage($page);
    }

    $pages = [];

    for ($x = 0; $x < $pagination['pages']; $x++) {

        array_push($pages, [
            'href' => '/contratos?' . http_build_query([
                'page' => $x + 1,
                'search' => $search
            ]),
            'text' => $x + 1
        ]);
    }

    $page = new Page();

    $i = 0;
    foreach ($pagination['data'] as &$value) {
        $value['id'] = $i;
        $i++;
    }

    $page->setTpl("contratos", [
        "contrato" => $pagination['data'],
        "search" => $search,
        "pages" => $pages,
        "error" => Contrato::getMsgError()
    ]);
});

$app->get("/contratos/create", function() {

    User::verifyLogin();
    User::setSessao("contratos,contratos,");

    $page = new Page();

    $page->setTpl("contratos-create", [
        "error" => Contrato::getMsgError()
    ]);
});

$app->post("/contratos/create", function() {

    User::verifyLogin();

    $contrato = new Contrato();

    $result = new Contrato();
    $result = $result->buscaProtocolo($_POST['Contrato_Protocolo']);

    if (count($result) > 0) {

        Contrato::setMsgError("Contrato " . $_POST['Contrato_Protocolo'] . " já Cadastrado!");
        header('Location: /contratos/create');
        exit;
    } else {
        $contrato->setData($_POST);
        $contrato->setContrato_Status(1);

        $contrato->save();

        header("Location: /contratos");
        exit;
    }
});

$app->get("/contratos/:idContrato/delete", function($idContrato) {

    User::verifyLogin();

    $contrato = new Contrato();

    $contrato->get((int) $idContrato);

    $result = new Contrato();
    $result = $contrato->buscaLancamento($idContrato);

    if (count($result) > 0) {
        Contrato::setMsgError("Contrato possui Lançamento(s) Cadastrado(s). Não é possível excluir: ");
    } else {
        $contrato->delete();
    }
    header("Location: /contratos");
    exit;
});

$app->get("/contratos/:idContrato", function($idContrato) {

    User::verifyLogin();
    User::setSessao("contratos,contratos,");

    $contrato = new Contrato();

    $contrato->get((int) $idContrato);

    $page = new Page();

    $page->setTpl("contratos-update", [
        "contrato" => $contrato->getValues(),
        "error" => Contrato::getMsgError()
    ]);
});

$app->post("/contratos/:idContrato", function($idContrato) {

    User::verifyLogin();

    $contrato = new Contrato();

    $contrato->get((int) $idContrato);

    $contrato->setData($_POST);

    $contrato->save();

    header("Location: /contratos");
    exit;
});

$app->get("/lanccontratos", function($idContrato) {

    User::verifyLogin();
    User::setSessao("contratos,lanccontratos,");

    $contrato = new Contrato();

    $contrato->get((int) $idContrato);

    $page = new Page();

    $page->setTpl("contrato-lanc", [
        "contrato" => $contrato->getValues(),
        "error" => Contrato::getMsgError()
    ]);
});
