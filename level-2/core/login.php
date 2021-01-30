<?php 
session_start();

require 'functions.php';

$email = $_POST['email'];
$password = $_POST['password'];

$auth = login( $email, $password );

if ( !$auth ) {
    set_flash_message('danger', "Введены не правельные данные. Попробыйте еще раз.");
    redirect_to ( '../page_login.php' );
    die;
}

redirect_to('../users.php');