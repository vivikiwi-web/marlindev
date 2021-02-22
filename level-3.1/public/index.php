<?php
// if (!session_id()) @session_start();

require __DIR__ . "/../config/config.php"; // Require config global variables
require ROOT . "/vendor/autoload.php";
require ROOT . "/core/libs/helpres.php"; // Require helpers

use Core\DB;
use Delight\Auth\Auth;
use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;

$DI_Builder = new DI\ContainerBuilder();
$DI_Builder->addDefinitions([
    Engine::class => function () {
        return new Engine(ROOT . '/app/views/');
    },

    QueryFactory::class => function () {
        return new QueryFactory('mysql');
    },

    Auth::class => function () {
        return new Auth(DB::getInstance());
    }
    
]);

$DI = $DI_Builder->build();

// // Router
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\DashboardController', 'indexAction']);

    $r->addRoute('GET', '/register', ['App\Controllers\UserController', 'indexAction']);
    $r->addRoute('POST', '/register', ['App\Controllers\UserController', 'registerAction']);

    $r->addRoute('GET', '/verification/{selector}/{token}', ['App\Controllers\UserController', 'verificationAction']);
    // $r->addRoute('GET', '/verification', ['App\Controllers\UserController', 'verificationAction']);

    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// // Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = str_replace(PROOT, "", $_SERVER["REQUEST_URI"]);

// // Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = $routeInfo[1];
        $params = $routeInfo[2];
        $DI->call( $controller,$params );
        break;
}