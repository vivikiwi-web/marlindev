<?php

session_start();
require 'functions.php';

// Security if someone will open this page directly
check_if_post_not_empty($_POST, '../users.php');

// Extract all $_POST values with keys and create dynamic variables
extract( $_POST );

$current_user_email = $_SESSION['auth']['email'];

$edit_user_info = get_user_by_email( $email );

if ( !empty($edit_user_info) && $current_user_email !== $edit_user_info['email'] ) {

    set_flash_message('danger', "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
    redirect_to ( "../security.php?id={$edit_user_id}" );
    die;

}

$result = compare_fields( $password, $password_repeat);

if ( !$result ) {

    set_flash_message('danger', "<strong>Уведомление!</strong> Пароли не совпадают.");
    redirect_to ( "../security.php?id={$edit_user_id}" );
    die;

}

// Update fields in databse
update_query_by_id('users', [$email, $password], $edit_user_id);

// Set flash success message
set_flash_message('success', 'Профиль успешно обновлен.');

// Redirect to the users list page
redirect_to('../users.php');






