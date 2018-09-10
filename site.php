<?php

use \SMSPlan\Page;
use \SMSPlan\Model\User;
use SMSPlan\Model\Unidade;
use SMSPlan\Model\Grupo;
use SMSPlan\Model\SubGrupo;
use SMSPlan\Model\CCusto;
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

    User::verifyLogin();
    User::setSessao("custos,relcc,");

    $page = new Page();

    $unidade = Unidade::listAll();
    $grupo = Grupo::listAll();
    $subgrupo = SubGrupo::listAll();
    $ccusto = CCusto::listAll();

    $page->setTpl("relcc", [
        "unidade" => $unidade,
        "grupo" => $grupo,
        "subgrupo" => $subgrupo,
        "ccusto" => $ccusto,
        "error" => CCusto::getMsgError()
    ]);
});

$app->post('/relcc', function() {

    User::verifyLogin(false);
    User::setSessao("custos,relcc,");

    if ($_POST['ano'] < 2000) {
        CCusto::setMsgError("Necessário Informar o Ano desejado");
        header('Location: /relcc');
        exit;
    }

    if ($_POST['mes'] <= 0) {
        CCusto::setMsgError("Necessário Informar o Quadrimestre desejado");
        header('Location: /relcc');
        exit;
    }

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

    $ano = $_POST['ano'];
    $mesi = $_POST['mes'];

    $cond = '';
    $mes1 = 'Jan';
    $mes2 = 'Fev';
    $mes3 = 'Mar';
    $mes4 = 'Abr';

    if ($mesi == 1) {
        $mes1 = 'Jan';
        $mes2 = 'Fev';
        $mes3 = 'Mar';
        $mes4 = 'Abr';
    }
    if ($mesi == 5) {
        $mes1 = 'Mai';
        $mes2 = 'Jun';
        $mes3 = 'Jul';
        $mes4 = 'Ago';
    }
    if ($mesi == 9) {
        $mes1 = 'Set';
        $mes2 = 'Out';
        $mes3 = 'Nov';
        $mes4 = 'Dez';
    }

    if ($_POST['id_CentroCusto'] != 'null') {
        $cond = $cond . ' AND id_CentroCusto = ' . $_POST['id_CentroCusto'];
    }
    if ($_POST['id_Unidade'] != 'null') {
        $cond = $cond . ' AND b.id_Unidade = ' . $_POST['id_Unidade'];
    }
    if ($_POST['id_GrupoCC'] != 'null') {
        $cond = $cond . ' AND id_GrupoCC = ' . $_POST['id_GrupoCC'];
    }
    if ($_POST['id_SubGrupoCC'] != 'null') {
        $cond = $cond . ' AND id_SubGrupoCC = ' . $_POST['id_SubGrupoCC'];
    }

    $centrosdecusto = RelCC::ListCC($ano, $mesi, $cond);

    if (count($centrosdecusto) > 0) {
        $pageh->setTpl("relccheader");

        $unidade = "";
        $gcc = "";
        $gscc = "";

        $tMes1 = 0;
        $tMes2 = 0;
        $tMes3 = 0;
        $tMes4 = 0;

        foreach ($centrosdecusto as $cc) {


            $pagec->setTpl("relccheadercc", [
                "mes1" => $mes1,
                "mes2" => $mes2,
                "mes3" => $mes3,
                "mes4" => $mes4,
                "ano" => $ano,
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

            $tMes1 += $cc['Mes1'];
            $tMes2 += $cc['Mes2'];
            $tMes3 += $cc['Mes3'];
            $tMes4 += $cc['Mes4'];

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

        $pagef->setTpl("relccfooter", [
            "tMes1" => $tMes1,
            "tMes2" => $tMes2,
            "tMes3" => $tMes3,
            "tMes4" => $tMes4
        ]);
    }
});
?>