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

// Get current user role
$userRole = ( $editUser->data()->group_id == 1 ) ? 2 : 1;

// Get group names
$group = $pdo->get( "groups", ["id", "=", $userRole] )->first();

// Set New Role
$editUser->update([
    "group_id" => $userRole
], $editUser->data()->id );

// Set "success" Flash message
Session::put("success", "Роль пользователя была изменина на '{$group->name}'");

// Redirect to Admin index
Redirect::to("index.php");