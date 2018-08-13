<?php

use SMSPlan\Page;
use SMSPlan\Model\User;
use SMSPlan\Model\GrupoItem;
use SMSPlan\Model\ItemCC;

$app->get("/grupositem", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,grupositem");

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

    if ($search != '') {

        $pagination = GrupoItem::getPageSearch($search, $page);
    } else {

        $pagination = GrupoItem::getPage($page);
    }

    $pages = [];

    for ($x = 0; $x < $pagination['pages']; $x++) {

        array_push($pages, [
            'href' => '/grupositem?' . http_build_query([
                'page' => $x + 1,
                'search' => $search
            ]),
            'text' => $x + 1
        ]);
    }

    $page = new Page();

    $page->setTpl("grupositem", [
        "grupositem" => $pagination['data'],
        "search" => $search,
        "pages" => $pages,
        "error" => GrupoItem::getMsgError()
    ]);
});

$app->get("/grupositem/create", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,grupositem");

    $page = new Page();

    $ordem = GrupoItem::maxOrdem();

    $page->setTpl("grupositem-create", [
        "ordem" => $ordem[0],
        "error" => GrupoItem::getMsgError()
    ]);
});


$app->post("/grupositem/create", function() {

    User::verifyLogin();

    $grupo = new GrupoItem();

    $result = new GrupoItem();
    $result = $result->buscaDescricao($_POST['DescGrupoItemCC']);

    if (count($result) > 0) {

        GrupoItem::setMsgError("Grupo " . $_POST['DescGrupoItemCC'] . " já Cadastrado!");
        header('Location: /grupositem/create');
        exit;
    } else {

        $grupo->setData($_POST);

        $grupo->save();

        header("Location: /grupositem");
        exit;
    }
});

$app->get("/grupositem/:idGrupoItemCC/delete", function($idGrupoItemCC) {

    User::verifyLogin();

    $grupo = new GrupoItem();

    $grupo->get((int) $idGrupoItemCC);

    $result = new GrupoItem();
    $result = $grupo->buscaItem($idGrupoItemCC);


    if (count($result) > 0) {
        GrupoItem::setMsgError("Grupo possui Ítens Cadastrado. Não é possível excluir: " . $grupo->getDescGrupoItemCC());
    } else {
        $grupo->delete();
    }
    header("Location: /grupositem");
    exit;
});

$app->get("/grupositem/:idGrupoItemCC", function($idGrupoItemCC) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,grupositem");

    $grupo = new GrupoItem();

    $grupo->get((int) $idGrupoItemCC);

    $page = new Page();

    $page->setTpl("grupositem-update", [
        "grupoitem" => $grupo->getValues(),
        "error" => $grupo->getMsgError()
    ]);
});

$app->post("/grupositem/:idGrupoItemCC", function($idGrupoItemCC) {

    User::verifyLogin();

    $grupo = new GrupoItem();

    $grupo->get((int) $idGrupoItemCC);

    $grupo->setData($_POST);

    $grupo->save();

    header("Location: /grupositem");
    exit;
});

$app->get("/grupositem/:idGrupoCC/itens", function($idGrupoItemCC) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,grupositem");

    $grupo = new GrupoItem();

    $grupo->get((int) $idGrupoItemCC);

    $page = new Page();

    $page->setTpl("grupositem-itens", [
        "grupoitem" => $grupo->getValues(),
        'itemRelated' => $grupo->getItemCC(),
        'itemNotRelated' => $grupo->getItemCC(false)
    ]);
});

$app->get("/grupositem/:idGrupoCC/itens/:idItemCC/add", function($idGrupoItemCC, $idItemCC) {

    User::verifyLogin();

    $grupo = new GrupoItem();

    $grupo->get((int) $idGrupoItemCC);

    $item = new ItemCC();

    $item->get((int) $idItemCC);

    $grupo->addItem($item);

    header("Location: /grupositem/" . $idGrupoItemCC . "/itens");
    exit;
});
