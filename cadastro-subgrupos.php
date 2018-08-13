<?php

use SMSPlan\Page;
use SMSPlan\Model\User;
use SMSPlan\Model\SubGrupo;
use SMSPlan\Model\Ccusto;

$app->get("/subgrupos", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,subgrupos");

    $search = (isset($_GET['search'])) ? $_GET['search'] : "";
    $page = (isset($_GET['page'])) ? (int) $_GET['page'] : 1;

    if ($search != '') {

        $pagination = SubGrupo::getPageSearch($search, $page);
    } else {

        $pagination = SubGrupo::getPage($page);
    }

    $pages = [];

    for ($x = 0; $x < $pagination['pages']; $x++) {

        array_push($pages, [
            'href' => '/subgrupos?' . http_build_query([
                'page' => $x + 1,
                'search' => $search
            ]),
            'text' => $x + 1
        ]);
    }

    $page = new Page();

    $page->setTpl("subgrupos", [
        "subgrupos" => $pagination['data'],
        "search" => $search,
        "pages" => $pages,
        "error" => SubGrupo::getMsgError()
    ]);
});

$app->get("/subgrupos/create", function() {

    User::verifyLogin();
    User::setSessao("custos,cadastros,subgrupos");

    $page = new Page();

    $ordem = SubGrupo::maxOrdem();

    $page->setTpl("subgrupos-create", [
        "ordem" => $ordem[0],
        "error" => SubGrupo::getMsgError()
    ]);
});


$app->post("/subgrupos/create", function() {

    User::verifyLogin();

    $subgrupo = new SubGrupo();

    $result = new SubGrupo();
    $result = $result->buscaDescricao($_POST['DescSubGrupoCC']);

    if (count($result) > 0) {

        SubGrupo::setMsgError("SubGrupo " . $_POST['DescSubGrupoCC'] . " já Cadastrado!");
        header('Location: /subgrupos/create');
        exit;
    } else {

        $subgrupo->setData($_POST);

        $subgrupo->save();

        header("Location: /subgrupos");
        exit;
    }
});

$app->get("/subgrupos/:idSubGrupoCC/delete", function($idSubGrupoCC) {

    User::verifyLogin();

    $subgrupo = new SubGrupo();

    $subgrupo->get((int) $idSubGrupoCC);

    $result = new SubGrupo();
    $result = $result->buscaCusto($idSubGrupoCC);


    if (count($result) > 0) {
        SubGrupo::setMsgError("SubGrupo possui Centro de Custo Cadastrado. Não é possível excluir: " . $subgrupo->getDescSubGrupoCC());
    } else {
        $subgrupo->delete();
    }
    header("Location: /subgrupos");
    exit;
});

$app->get("/subgrupos/:idSubGrupoCC", function($idSubGrupoCC) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,subgrupos");

    $subgrupo = new SubGrupo();

    $subgrupo->get((int) $idSubGrupoCC);

    $page = new Page();

    $page->setTpl("subgrupos-update", [
        "subgrupo" => $subgrupo->getValues(),
        "error" => $subgrupo->getMsgError()
    ]);
});

$app->post("/subgrupos/:idSubGrupoCC", function($idSubGrupoCC) {

    User::verifyLogin();

    $subgrupo = new SubGrupo();

    $subgrupo->get((int) $idSubGrupoCC);

    $subgrupo->setData($_POST);

    $subgrupo->save();

    header("Location: /subgrupos");
    exit;
});

$app->get("/subgrupos/:idSubGrupoCC/ccustos", function($idSubGrupoCC) {

    User::verifyLogin();
    User::setSessao("custos,cadastros,subgrupos");

    $subgrupo = new SubGrupo();

    $subgrupo->get((int) $idSubGrupoCC);

    $page = new Page();

    $page->setTpl("subgrupos-ccusto", [
        "subgrupo" => $subgrupo->getValues(),
        'ccustosRelated' => $subgrupo->getCcustos(),
        'ccustosNotRelated' => $subgrupo->getCcustos(false)
    ]);
});

$app->get("/subgrupos/:idSubGrupoCC/ccustos/:idCentroCusto/add", function($idSubGrupoCC, $idCentroCusto) {

    User::verifyLogin();

    $subgrupo = new SubGrupo();

    $subgrupo->get((int) $idSubGrupoCC);

    $ccusto = new Ccusto();

    $ccusto->get((int) $idCentroCusto);

    $subgrupo->addCcusto($ccusto);

    header("Location: /subgrupos/" . $idSubGrupoCC . "/ccustos");
    exit;
});

$app->get("/subgrupos/:idSubGrupoCC/ccustos/:idCentroCusto/remove", function($idSubGrupoCC, $idCentroCusto) {

    User::verifyLogin();

    $subgrupo = new SubGrupo();

    $subgrupo->get((int) $idSubGrupoCC);

    $ccusto = new Ccusto();

    $ccusto->get((int) $idCentroCusto);

    $subgrupo->removeCcusto($ccusto);

    header("Location: /subgrupos/" . $idSubGrupoCC . "/ccustos");
    exit;
});
