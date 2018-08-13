<?php

use SMSPlan\Page;
use SMSPlan\Model\User;
use SMSPlan\Model\GrupoItem;
use SMSPlan\Model\ItemCC;

$app->get("/itenslanc", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,itenslanc");

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

    if ($search != '') {

        $pagination = ItemCC::getPageSearch($search, $page);
    } else {

        $pagination = ItemCC::getPage($page);
    }

    $pages = [];

    for ($x = 0; $x < $pagination['pages']; $x++) {

        array_push($pages, [
            'href' => '/itenslanc?' . http_build_query([
                'page' => $x + 1,
                'search' => $search
            ]),
            'text' => $x + 1
        ]);
    }

    $page = new Page();

    $page->setTpl("itenscc", [
        "itenslanc" => $pagination['data'],
        "search" => $search,
        "pages" => $pages,
        "error" => ItemCC::getMsgError()
    ]);
});

$app->get("/itenslanc/create", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,itenslanc");

    $page = new Page();

    $grupoitem = GrupoItem::listAll();

    $page->setTpl("itenscc-create", [
        "grupoitem" => $grupoitem,
        "error" => ItemCC::getMsgError()
    ]);
});

$app->post("/itenslanc/create", function() {

    User::verifyLogin();

    $itemcc = new ItemCC();

    $result = new ItemCC();
    $result = $result->buscaDescricao($_POST['DescItemCC']);

    if (count($result) > 0) {

        ItemCC::setMsgError("Ítem de lançamento " . $_POST['DescItemCC'] . " já Cadastrado!");
        header('Location: /itenslanc/create');
        exit;
    } else {

        $itemcc->setData($_POST);

        $itemcc->save();

        header("Location: /itenslanc");
        exit;
    }
});

$app->get("/itenslanc/:idItemCC/delete", function($idItemCC) {

    User::verifyLogin();

    $itemcc = new ItemCC();

    $itemcc->get((int) $idItemCC);

    $result = new ItemCC();
    $result = $itemcc->buscaMovCusto($idItemCC);

    if (count($result) > 0) {
        ItemCC::setMsgError("Item de Lançamento possui Movimento Cadastrado. Não é possível excluir: " . $itemcc->getDescItemCC());
    } else {
        $itemcc->delete();
    }
    header("Location: /itenslanc");
    exit;
});

$app->get("/itenslanc/:idItemCC", function($idItemCC) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,itenslanc");

    $itemcc = new ItemCC();

    $itemcc->get((int) $idItemCC);

    $grupoitem = GrupoItem::listAll();

    $page = new Page();

    $page->setTpl("itenscc-update", [
        "grupoitem" => $grupoitem,
        "itemcc" => $itemcc->getValues(),
        "error" => ItemCC::getMsgError()
    ]);
});

$app->post("/itenslanc/:idItemCC", function($idItemCC) {

    User::verifyLogin();

    $itemcc = new ItemCC();

    $itemcc->get((int) $idItemCC);

    $itemcc->setData($_POST);

    $itemcc->save();

    header("Location: /itenslanc");
    exit;
});

