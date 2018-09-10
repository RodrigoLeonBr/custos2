<?php

use SMSPlan\Page;
use SMSPlan\Model\User;
use SMSPlan\Model\Grupo;
use SMSPlan\Model\CCusto;

$app->get("/grupos", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,grupos");

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

    if ($search != '') {

        $pagination = Grupo::getPageSearch($search, $page);
    } else {

        $pagination = Grupo::getPage($page);
    }

    $pages = [];

    for ($x = 0; $x < $pagination['pages']; $x++) {

        array_push($pages, [
            'href' => '/grupos?' . http_build_query([
                'page' => $x + 1,
                'search' => $search
            ]),
            'text' => $x + 1
        ]);
    }

    $page = new Page();

    $page->setTpl("grupos", [
        "grupos" => $pagination['data'],
        "search" => $search,
        "pages" => $pages,
        "error" => Grupo::getMsgError()
    ]);
});

$app->get("/grupos/create", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,grupos");

    $page = new Page();

    $ordem = Grupo::maxOrdem();

    $page->setTpl("grupos-create", [
        "ordem" => $ordem[0],
        "error" => Grupo::getMsgError()
    ]);
});


$app->post("/grupos/create", function() {

    User::verifyLogin();

    $grupo = new Grupo();

    $result = new Grupo();
    $result = $result->buscaDescricao($_POST['DescGrupoCC']);

    if (count($result) > 0) {

        Grupo::setMsgError("Grupo " . $_POST['DescGrupoCC'] . " já Cadastrado!");
        header('Location: /grupos/create');
        exit;
    } else {

        $grupo->setData($_POST);

        $grupo->save();

        header("Location: /grupos");
        exit;
    }
});

$app->get("/grupos/:idGrupoCC/delete", function($idGrupoCC) {

    User::verifyLogin();

    $grupo = new Grupo();

    $grupo->get((int) $idGrupoCC);

    $result = new Grupo();
    $result = $grupo->buscaCusto($idGrupoCC);


    if (count($result) > 0) {
        Grupo::setMsgError("Grupo possui Centro de Custo Cadastrado. Não é possível excluir: " . $grupo->getDescGrupoCC());
    } else {
        $grupo->delete();
    }
    header("Location: /grupos");
    exit;
});

$app->get("/grupos/:idGrupoCC", function($idGrupoCC) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,grupos");

    $grupo = new Grupo();

    $grupo->get((int) $idGrupoCC);

    $page = new Page();

    $page->setTpl("grupos-update", [
        "grupo" => $grupo->getValues(),
        "error" => $grupo->getMsgError()
    ]);
});

$app->post("/grupos/:idGrupoCC", function($idGrupoCC) {

    User::verifyLogin();

    $grupo = new Grupo();

    $grupo->get((int) $idGrupoCC);

    $grupo->setData($_POST);

    $grupo->save();

    header("Location: /grupos");
    exit;
});

$app->get("/grupos/:idGrupoCC/ccustos", function($idGrupoCC) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,grupos");

    $grupo = new Grupo();

    $grupo->get((int) $idGrupoCC);

    $page = new Page();

    $page->setTpl("grupos-ccusto", [
        "grupo" => $grupo->getValues(),
        'ccustosRelated' => $grupo->getCcustos(),
        'ccustosNotRelated' => $grupo->getCcustos(false)
    ]);
});

$app->get("/grupos/:idGrupoCC/ccustos/:idCentroCusto/add", function($idGrupoCC, $idCentroCusto) {

    User::verifyLogin();

    $grupo = new Grupo();

    $grupo->get((int) $idGrupoCC);

    $ccusto = new CCusto();

    $ccusto->get((int) $idCentroCusto);

    $grupo->addCCusto($ccusto);

    header("Location: /grupos/" . $idGrupoCC . "/ccustos");
    exit;
});

$app->get("/grupos/:idGrupoCC/ccustos/:idCentroCusto/remove", function($idGrupoCC, $idCentroCusto) {

    User::verifyLogin();

    $grupo = new Grupo();

    $grupo->get((int) $idGrupoCC);

    $ccusto = new CCusto();

    $ccusto->get((int) $idCentroCusto);

    $grupo->removeCcusto($ccusto);

    header("Location: /grupos/" . $idGrupoCC . "/ccustos");
    exit;
});
