<?php

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \SMSPlan\Model\User;

$app = new Slim();

$app->config('debug', true);

require_once("functions.php");
require_once("site.php");
require_once("cadastro-unidades.php");
require_once("cadastro-grupos.php");
require_once("cadastro-subgrupos.php");
require_once("cadastro-cc.php");
require_once("cadastro-grupositem.php");
require_once("cadastro-itemcc.php");
$app->run();
