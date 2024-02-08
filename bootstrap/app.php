<?php

require_once(__DIR__ . "/../system/helpers/helpers.php");
require_once(__DIR__ . "/../config/app.php");
require_once(__DIR__ . "/../config/database.php");

require_once(__DIR__ . "/../routes/web.php");
require_once(__DIR__ . "/../routes/api.php");

$routing = new \System\Router\Routing();
$routing->run();
