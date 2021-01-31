<?php

session_start();
require 'functions.php';

if ( !isset($_GET['id']) ) {
    redirect_to('../users.php');
    exit;
}

$logged_user_id = $_SESSION['auth']['id'];
$delete_user_id = $_GET['id'];

if ( is_usert_not_logged_in() ) {
    redirect_to('../page_login.php');
    exit;
}

if ( !is_admin() && !is_author( $logged_user_id, $delete_user_id ) ) {
    set_flash_message('danger', 'Можно только свой профиль удалить.');
    redirect_to('../users.php');
    exit;
}

delete_row_by_id( 'users', $delete_user_id );

if ( $logged_user_id == $delete_user_id ) {
    logout();
    redirect_to('../page_login.php');
}

set_flash_message('danger', 'Профиль успешно удален.');
redirect_to('../users.php');

