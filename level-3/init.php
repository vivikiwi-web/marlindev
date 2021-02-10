<?php
session_start();

require_once "inc/helpers.php";
require_once "classes/Database.php";
require_once "classes/Config.php";
require_once "classes/Input.php";
require_once "classes/Validate.php";
require_once "classes/Token.php";
require_once "classes/Session.php";
require_once "classes/User.php";
require_once "classes/Redirect.php";

$GLOBALS["config"] = [
    "mysql" => [
        "host"     => "localhost",
        "username" => "root",
        "password" => "root",
        "dbname"   => "marlindev_3level",
    ],
    "db_table" => [
        "users_table" => [
            "name" => "users",
            "login_main_field" => "email",
        ]
    ],
    "session" => [
        "token_name" => "token",
        "user_session" => "user",
    ]
];