<?php 
session_start();

require 'functions.php';

// Extract all $_POST values with keys and create dynamic variables
extract($_POST, EXTR_OVERWRITE);

$auth = login( $email, $password );

if ( !$auth ) {
    set_flash_message('danger', "Введены не правельные данные. Попробыйте еще раз.");
    redirect_to ( '../page_login.php' );
    die;
}

redirect_to('../users.php');