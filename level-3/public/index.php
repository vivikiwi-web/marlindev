<?php
 // Удаляем /public из дериктории.
$proot = str_replace( "public", "", dirname(__FILE__));

 // создаем глобальную перемменую которая указыват на папку проекта
define("ROOT", $proot);

include ROOT . "functions.php";
$config = include ROOT . "config.php";

$requestURI = str_replace( $config["root"], "", $_SERVER["REQUEST_URI"]);

$routes = [
    "/" => "controllers/homepage.php",
    "/about" => "about.view.php",
    // "/create" => "create.view.php",
    // "/edit" => "edit.view.php?id=4",
];

if ( array_key_exists( $requestURI, $routes )) {
    include ROOT . $routes[$requestURI];exit;
} else {
    dd("404");
}