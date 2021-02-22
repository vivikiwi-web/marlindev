<?php 
// Remove public from URL and set global variable ROOT
define(ROOT, str_replace("public", "", dirname(__FILE__)) );

require_once __DIR__ . "/../config/config.php";



// Require helpers
require_once ROOT . "libs/helpres.php";

// Require bootstrap (autoload)
require_once ROOT . "vendors/bootstrap/bootstrap.php";

$router = new Router;
$router->run();