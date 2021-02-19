<?php
include ROOT . "functions.php";
$db = include ROOT . "database/start.php";

$db->create( "posts", [
    "title" => $_POST["title"],
] );

header("Location: index.php");