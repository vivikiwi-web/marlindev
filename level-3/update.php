<?php
include  ROOT . "functions.php";
$db = include  ROOT . "database/start.php";

$db->update( "posts", $_POST, $_GET["id"]);

header("Location: index.php");