<?php
$config = include ROOT . "config.php";
include "Connection.php";
include "QueryBuilder.php";

return new QueryBuilder( Connection::make( $config["database"] ) );