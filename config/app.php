<?php
define('APP_TITLE', 'mvc project');

define('BASE_URL', 'http://localhost:8000');

define('BASE_DIR', realpath(__DIR__ . "/../"));

$temporary = str_replace(BASE_URL, "", explode("?", $_SERVER["REQUEST_URI"])[0]);

$temporary === "/" ? $temporary = "" : $temporary = substr($temporary, 1);

define("CURRENT_ROUTE", $temporary);

global $routes;

$routes = [
    "get" => [],
    "post" => [],
    "put" => [],
    "delete" => []
];
