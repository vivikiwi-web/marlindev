<?php

require_once "helpers.php";
require_once "Database.php";

$pdo = Database::getInstance();

// $pdo->update( "users", 5, ["username"=>"sania","password"=>"password2"]);
// $pdo->insert( "users", ["username"=>"valia","password"=>"password"]);
// $users = $pdo->query( "SELECT * FROM users WHERE username IN (?,?)", ["vitalij", "zulik"] );
// $users = $pdo->get( "users", ["username", "=", "vitalij"] )->count();
// $users = $pdo->get( "users", ["username", "=", "vitalij"] );
// $users = $pdo->delete( "users", ["username", "=", "test"] );


$users = $pdo->query( "SELECT * FROM users");

echo $users->first()->username;

// echo $users;
// if ( $users->errors() ) {
//     echo "something goes wrong";
// } else {
//     foreach ( $users->results() as $user ) {
//         echo $user->username . "<br />";
//     }
// }