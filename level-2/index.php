<?php
require_once "init.php";

// echo Session::get(Config::get('session.user_session') );

echo Session::flash("success") . "<br />";
$user = new User;

if ( $user->isLoggedIn() ) {
    echo "Hello, <a href='#' >{$user->data()->username}</a>";
    echo "<p><a href='update.php'>Update Username</a></p>";
    echo "<p><a href='logout.php'>Logout</a></p>";
    echo "<p><a href='change-password.php'>Change Password</a></p>";

    if ( $user->hasPermissions("admin") ) {
        echo "You are admin";
    }
} else {
    echo "<a href='login.php'>Login</a> or <a href='register.php'>Register</a>";
}
