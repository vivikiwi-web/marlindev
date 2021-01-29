<?php
session_start();

require "functions.php";

$email = $_POST['email'];
$password = $_POST['password'];

$is_user = get_user_by_email( $email );

if ( !empty($is_user) ) {

    set_flash_message('danger', "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
    redirect_to ( 'page_register.php' );
    die;
}

add_email ( $email, $password );
set_flash_message('success', "Регистрация успешна.");
redirect_to ( 'page_login.php' );