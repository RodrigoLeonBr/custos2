<?php

use \SMSPlan\Model\User;

function formatValor($vl) {

    if (!$vl > 0)
        $vl = 0;

    return number_format($vl, 2, ",", ".");
}

function formatPercent($vlinit, $vltot) {

    if (($vlinit <= 0) || ($vltot <= 0)) {
        return number_format(0, 2, ",", ".");
    } else {
        return number_format(($vlinit / $vltot) * 100, 2, ",", ".");
    }
}

function formatDate($date) {

    return date('d/m/Y', strtotime($date));
}

function checkLogin($inadmin = true) {

    return User::checkLogin($inadmin);
}

function getUserName() {

    $user = User::getFromSession();

    return $user->getdesperson();
}

function getMenu() {

    $msg = User::getSessao();
    $texto = explode(",", $msg);

    return $texto[0];
}

function getSubmenu() {

    $msg = User::getSessao();
    $texto = explode(",", $msg);

    return $texto[1];
}

function getSubSubmenu() {

    $msg = User::getSessao();
    $texto = explode(",", $msg);

    return $texto[2];
}

function getUserDate() {

    $user = User::getFromSession();

    return date('m-Y', strtotime($user->getdtregister()));
}

function post($key) {
    return str_replace("'", "", $_POST[$key]);
}

function get($key) {
    return str_replace("'", "", $_GET[$key]);
}

?>