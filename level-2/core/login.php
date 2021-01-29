<?php 
session_start();

require 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$auth = login( $email, $password );

if ( !$auth ) {
    redirect_to ( '../page_login.php' );
    die;
}

redirect_to('../users.php');