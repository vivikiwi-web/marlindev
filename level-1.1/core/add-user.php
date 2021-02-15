<?php
session_start();
require "functions.php";

// Security if someone will open this page directly
check_if_post_not_empty($_POST, '../users.php');

// Extract all $_POST values with keys and create dynamic variables
extract($_POST, EXTR_OVERWRITE);

// Check if user exist
$is_user = get_user_by_email( $email );

if ( !empty($is_user) ) {

    set_flash_message('danger', "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
    redirect_to ( '../create_user.php' );
    die;
}

// Create user in database
$user_id = add_user ( $email, $password );

// Add user information
edit_user_information ( $fullname, $position, $phone, $address, $user_id );

// Set user status
set_status ( $status, $user_id );

// Add user social links
add_social_links ( $telegram, $instagram, $vk, $user_id );

// Upload user avatar image
upload_avatar ( $_FILES['image'], $user_id, '../create_user.php' );

// Set flash success message
set_flash_message('success', 'Профиль успешно добавлен.');

// Redirect to the user list page
redirect_to('../users.php');