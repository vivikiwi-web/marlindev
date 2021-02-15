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
require_once "classes/Cookie.php";

$GLOBALS["config"] = [
    "mysql" => [
        "host"     => "localhost",
        "username" => "root",
        "password" => "root",
        "dbname"   => "marlindev_level3_homework",
    ],
    "db_table" => [
        "users_table" => "users",
        "coockie_table" => "user_sessions",
        "group_table" => "groups",
    ],
    "session" => [
        "token_name"    => "token",
        "user_session"  => "user",
    ],
    "cookie" => [
        "cookie_name"   => "hash",
        "cookie_expite" => 604800
    ]
];


// If we have an COOKIE but there ar no SESSION, login user to dashboard
if ( Cookie::exists( Config::get("cookie.cookie_name")) && !Session::exists( Config::get("session.user_session")) ) {
    $cookieTable = Config::get( "db_table.coockie_table" ); // Get databse table name from CONFIG
    $hash = Cookie::get( Config::get( "cookie.cookie_name" ) ); // Get COOKIE hash from user by COOKIE CONFIG name
    $hashCheck = Database::getInstance()->get( $cookieTable, ["hash", "=", $hash] ); // Check if COOKIE esists in databse

    if ( $hashCheck->count() ) {
        $user = new User( $hashCheck->first()->user_id ); // create user instance
        $user->login(); // login user to dashboard
    }
}