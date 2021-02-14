<?php
session_start();
require_once "init.php";

$user = new User();

$user->logout();

Redirect::to("index.php");