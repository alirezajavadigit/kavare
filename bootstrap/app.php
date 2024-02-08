<?php
session_start();

if (isset($_SESSION['old'])) unset($_SESSION['temporary_old']);

if (isset($_SESSION['old'])) {
    $_SESSION['temporary_old'] = $_SESSION['old'];
    unset($_SESSION['old']);
}

$params = [];
$params = !isset($_GET) ? $params : array_merge($params, $_GET);
$params = !isset($_POST) ? $params : array_merge($params, $_POST);
$_SESSION['old'] = $params;
unset($params);

require_once(__DIR__ . "/../system/helpers/helpers.php");
require_once(__DIR__ . "/../config/app.php");
require_once(__DIR__ . "/../config/database.php");

require_once(__DIR__ . "/../routes/web.php");
require_once(__DIR__ . "/../routes/api.php");

$routing = new \System\Router\Routing();
$routing->run();
