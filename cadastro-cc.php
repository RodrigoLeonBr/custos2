<?php

use SMSPlan\Page;
use SMSPlan\Model\User;
use SMSPlan\Model\Unidade;
use SMSPlan\Model\Grupo;
use SMSPlan\Model\SubGrupo;
use SMSPlan\Model\CCusto;

$app->get("/ccustos", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,ccustos");

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

    if ($search != '') {

        $pagination = CCusto::getPageSearch($search, $page);
    } else {

        $pagination = CCusto::getPage($page);
    }

    $pages = [];

    for ($x = 0; $x < $pagination['pages']; $x++) {

        array_push($pages, [
            'href' => '/ccustos?' . http_build_query([
                'page' => $x + 1,
                'search' => $search
            ]),
            'text' => $x + 1
        ]);
    }

    $page = new Page();

    $page->setTpl("ccustos", [
        "ccustos" => $pagination['data'],
        "search" => $search,
        "pages" => $pages,
        "error" => CCusto::getMsgError()
    ]);
});

$app->get("/ccustos/create", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,ccustos");

    $page = new Page();

    $unidade = Unidade::listAll();
    $grupo = Grupo::listAll();
    $subgrupo = SubGrupo::listAll();

    $page->setTpl("ccustos-create", [
        "unidade" => $unidade,
        "grupo" => $grupo,
        "subgrupo" => $subgrupo,
        "error" => CCusto::getMsgError()
    ]);
});

$app->post("/ccustos/create", function() {

    User::verifyLogin();

    $ccusto = new CCusto();

    $result = new CCusto();
    $result = $result->buscaDescricao($_POST['DescCentroCusto']);

    if (count($result) > 0) {

        CCusto::setMsgError("C Custo " . $_POST['DescCentroCusto'] . " já Cadastrado!");
        header('Location: /ccustos/create');
        exit;
    } else {

        $ccusto->setData($_POST);

        $ccusto->save();

        header("Location: /ccustos");
        exit;
    }
});

$app->get("/ccustos/:idCentroCusto/delete", function($idCentroCusto) {

    User::verifyLogin();

    $ccusto = new CCusto();

    $ccusto->get((int) $idCentroCusto);

    $result = new CCusto();
    $result = $ccusto->buscaMovCusto($idCentroCusto);

    if (count($result) > 0) {
        CCusto::setMsgError("Centro de Custo possui Movimento Cadastrado. Não é possível excluir: " . $ccusto->getDescCentroCusto());
    } else {
        $ccusto->delete();
    }
    header("Location: /ccustos");
    exit;
});

$app->get("/ccustos/:idCentroCusto", function($idCentroCusto) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,ccustos");

    $ccusto = new CCusto();

    $ccusto->get((int) $idCentroCusto);

    $unidade = Unidade::listAll();
    $grupo = Grupo::listAll();
    $subgrupo = SubGrupo::listAll();

    $page = new Page();

    $page->setTpl("ccustos-update", [
        "unidade" => $unidade,
        "grupo" => $grupo,
        "subgrupo" => $subgrupo,
        "ccusto" => $ccusto->getValues(),
        "error" => CCusto::getMsgError()
    ]);
});

$app->post("/ccustos/:idCentroCusto", function($idCentroCusto) {

    User::verifyLogin();

    $ccusto = new CCusto();

    $ccusto->get((int) $idCentroCusto);

    $ccusto->setData($_POST);

    $ccusto->save();

    header("Location: /ccustos");
    exit;
});

