
<?php

// echo "Asd";
// dd(ROOT . "database/start.php");
$db = include ROOT . "database/start.php";

// dd($db);

$posts = $db->getAll( "posts" );

include ROOT . "index.view.php";