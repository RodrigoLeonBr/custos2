<?php

use SMSPlan\Page;
use SMSPlan\Model\User;
use SMSPlan\Model\Unidade;
use SMSPlan\Model\CCusto;

$app->get("/unidades", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,unidades");

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

    if ($search != '') {

        $pagination = Unidade::getPageSearch($search, $page);
    } else {

        $pagination = Unidade::getPage($page);
    }

    $pages = [];

    for ($x = 0; $x < $pagination['pages']; $x++) {

        array_push($pages, [
            'href' => '/unidades?' . http_build_query([
                'page' => $x + 1,
                'search' => $search
            ]),
            'text' => $x + 1
        ]);
    }

    $page = new Page();

    $page->setTpl("unidades", [
        "unidades" => $pagination['data'],
        "search" => $search,
        "pages" => $pages,
        "error" => Unidade::getMsgError()
    ]);
});

$app->get("/unidades/create", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,unidades");

    $page = new Page();

    $page->setTpl("unidades-create", [
        "error" => Unidade::getMsgError()
    ]);
});


$app->post("/unidades/create", function() {

    User::verifyLogin();

    $unidade = new Unidade();

    $result = new Unidade();
    $result = $result->buscaDescricao($_POST['UnDescricao']);

    if (count($result) > 0) {
        Unidade::setMsgError("Unidade " . $_POST['UnDescricao'] . " já Cadastrada!");
        header('Location: /unidades/create');
        exit;
    } else {

        $unidade->setData($_POST);

        $unidade->save();

        header("Location: /unidades");
        exit;
    }
});

$app->get("/unidades/:idUnidade/delete", function($idUnidade) {

    User::verifyLogin();

    $unidade = new Unidade();

    $unidade->get((int) $idUnidade);

    $result = new Unidade();
    $result = $result->buscaCusto($idUnidade);


    if (count($result) > 0) {
        Unidade::setMsgError("Unidade possui Centro de Custo Cadastrado. Não é possível excluir: " . $grupo->getUnDescricao());
    } else {
        $unidade->delete();
    }
    header("Location: /unidades");
    exit;
});

$app->get("/unidades/:idUnidade", function($idUnidade) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,unidades");

    $unidade = new Unidade();

    $unidade->get((int) $idUnidade);

    $page = new Page();

    $page->setTpl("unidades-update", [
        "unidade" => $unidade->getValues(),
        "error" => Unidade::getMsgError()
    ]);
});

$app->post("/unidades/:idUnidade", function($idUnidade) {

    User::verifyLogin();

    $unidade = new Unidade();

    $unidade->get((int) $idUnidade);

    $result = new Unidade();
    $result = $result->buscaDescricao($_POST['UnDescricao']);

    if (count($result) > 0) {
        Unidade::setMsgError("Unidade " . $_POST['UnDescricao'] . " já Cadastrada!");
        header('Location: /unidades/create');
        exit;
    } else {

        $unidade->setData($_POST);

        $unidade->save();

        header("Location: /unidades");
        exit;
    }
});

$app->get("/unidades/:idUnidade/ccustos", function($idUnidade) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,unidades");

    $unidade = new Unidade();

    $unidade->get((int) $idUnidade);

    $page = new Page();

    $page->setTpl("unidades-ccusto", [
        "unidade" => $unidade->getValues(),
        'ccustosRelated' => $unidade->getCcustos(),
        'ccustosNotRelated' => $unidade->getCcustos(false)
    ]);
});

$app->get("/unidades/:idUnidade/ccustos/:idCentroCusto/add", function($idUnidade, $idCentroCusto) {

    User::verifyLogin();

    $unidade = new Unidade();

    $unidade->get((int) $idUnidade);

    $ccusto = new CCusto();

    $ccusto->get((int) $idCentroCusto);

    $unidade->addCcusto($ccusto);

    header("Location: /unidades/" . $idUnidade . "/ccustos");
    exit;
});

$app->get("/unidades/:idUnidade/ccustos/:idCentroCusto/remove", function($idUnidade, $idCentroCusto) {

    User::verifyLogin();

    $unidade = new Unidade();

    $unidade->get((int) $idUnidade);

    $ccusto = new CCusto();

    $ccusto->get((int) $idCentroCusto);

    $unidade->removeCcusto($ccusto);

    header("Location: /unidades/" . $idUnidade . "/ccustos");
    exit;
});
