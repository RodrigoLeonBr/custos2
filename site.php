<?php

use \SMSPlan\Page;
use \SMSPlan\Model\User;
use \SMSPlan\Model\RelCC;

$app->get('/', function() {

    User::verifyLogin(false);
    User::setSessao("principal,,");

    $user = User::getFromSession();

    $page = new Page();

    $page->setTpl("index");
});

$app->get('/login', function() {

    $page = new Page([
        "header" => false,
        "footer" => false
    ]);

    $page->setTpl("login");
});

$app->post('/login', function() {


    User::login($_POST["login"], $_POST["password"]);

    header("Location: /");
    exit;
});

$app->get('/logout', function() {

    User::logout();

    header("Location: /login");
    exit;
});


$app->get("/forgot", function() {

    $page = new Page([
        "header" => false,
        "footer" => false
    ]);

    $page->setTpl("forgot");
});

$app->post("/forgot", function() {

    $user = User::getForgot($_POST["email"]);

    header("Location: /forgot/sent");
    exit;
});

$app->get("/forgot/sent", function() {

    $page = new Page([
        "header" => false,
        "footer" => false
    ]);

    $page->setTpl("forgot-sent");
});

$app->get("/forgot/reset", function() {

    $user = User::validForgotDecrypt($_GET["code"]);

    $page = new Page([
        "header" => false,
        "footer" => false
    ]);

    $page->setTpl("forgot-reset", array(
        "name" => $user["desperson"],
        "code" => $_GET["code"]
    ));
});

$app->post("/forgot/reset", function() {

    $forgot = User::validForgotDecrypt($_POST["code"]);

    User::setForgotUsed($forgot["idrecovery"]);

    $user = new User();

    $password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
        "cost" => 12
    ]);

    $user->get((int) $forgot["iduser"]);

    $user->setPassword($password);

    $page = new Page([
        "header" => false,
        "footer" => false
    ]);

    $page->setTpl("forgot-reset-success");
});

$app->get('/relcc', function() {

    User::verifyLogin(false);
    User::setSessao("custos,relcc,");

    $pageh = new Page([
        "header" => true,
        "footer" => false
    ]);
    $pagec = new Page([
        "header" => false,
        "footer" => false
    ]);
    $pagef = new Page([
        "header" => false,
        "footer" => true
    ]);

    $ano = 2017;
    $mesi = 1;

    $centrosdecusto = RelCC::ListCC($ano, $mesi);

    if (count($centrosdecusto) > 0) {
        $pageh->setTpl("relccheader");

        $unidade = "";
        $gcc = "";
        $gscc = "";

        foreach ($centrosdecusto as $cc) {


            $pagec->setTpl("relccheadercc", [
                "mes1" => 'Jan',
                "mes2" => 'Fev',
                "mes3" => 'Mar',
                "mes4" => 'Abr',
                "ano" => '2017',
                "unidade" => $unidade <> $cc['UnDescricao'] ? $cc['id_Unidade'] . '-' . $cc['UnDescricao'] : "",
                "grupo" => $gcc <> $cc['DescGrupoCC'] ? $cc['id_GrupoCC'] . '-' . $cc['DescGrupoCC'] : "",
                "subgrupo" => $gscc <> $cc['DescSubGrupoCC'] ? $cc['id_subGrupoCC'] . '-' . $cc['DescSubGrupoCC'] : "",
                "id_CentroCusto" => $cc["id_CentroCusto"],
                "DescCentroCusto" => $cc["DescCentroCusto"]
            ]);

            $unidade = $cc['UnDescricao'];
            $gcc = $cc['DescGrupoCC'];
            $gscc = $cc['DescSubGrupoCC'];

            $grupoitem = RelCC::ListGrupoCC($ano, $mesi, $cc["id_CentroCusto"]);

            foreach ($grupoitem as $grupo) {

                $detalhe = RelCC::ListGrupoDetCC($ano, $mesi, $cc["id_CentroCusto"], $grupo["id_GrupoItemCC"]);

                $pagec->setTpl("relccgrupo", [
                    "grupo" => $detalhe,
                    "totalgrupo" => $grupo,
                    "totalcc" => $cc,
                ]);
            }

            $pagec->setTpl("relccfootercc", [
                "grupo" => $cc
            ]);
            $pagec->setTpl("relccoutros");
        }

        $pagef->setTpl("relccfooter");
    }
});
?>