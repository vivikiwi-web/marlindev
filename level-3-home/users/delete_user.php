<?php
session_start();

require_once "../init.php";
$pdo = Database::getInstance();
$currentUser = new User;
$editUser = Input::get( 'id');

// Check if user logged in and User have Admin permissions
if ( !$currentUser->isLoggedIn() ) {
    if ( !$currentUser->hasPermissions("admin") ) {
        Redirect::to("index.php");
        exit;
    }
}

$editUser = new User( $editUser );

// Set New Role
$editUser->delete( $editUser->data()->id );

// Set "success" Flash message
Session::put("success", "Пользователь успешно удален.");

// Redirect to Admin index
Redirect::to("index.php");