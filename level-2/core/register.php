<?php
session_start();

require "functions.php";

// Extract all $_POST values with keys and create dynamic variables
extract($_POST, EXTR_OVERWRITE);

$is_user = get_user_by_email( $email );

if ( !empty($is_user) ) {

    set_flash_message('danger', "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
    redirect_to ( '../page_register.php' );
    die;
}

add_user ( $email, $password );
set_flash_message('success', "Регистрация успешна.");
redirect_to ( '../page_login.php' );