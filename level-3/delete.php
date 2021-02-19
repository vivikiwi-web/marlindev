<?php
include ROOT . "functions.php";
$db = include  ROOT . "database/start.php";

$db->delete( "posts", $_GET["id"]);

header("Location: index.php");