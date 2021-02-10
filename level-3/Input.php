<?php

class Input {

    public static function exists( string $post = "post" ) {
        switch ( $post ) {
            case "post":
                return ( !empty($_POST) ) ? true : false;
            case "get":
                return ( !empty($_GET) ) ? true : false;
            default:
                return false;
            break;
        }
    }

    public static function get ( string $field ) {
        if ( isset($_POST[$field]) ) {
            return $_POST[$field];
        } else if ( isset($_GET[$field]) ) {
            return $_GET[$field];
        }
        return "";
    }
}