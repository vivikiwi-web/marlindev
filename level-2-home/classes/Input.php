<?php

class Input {

    /**
     * Check if form was submited by method
     *
     * @param string $method
     * @return boolean
     */
    public static function exists( string $method = "post" ) {
        switch ( $method ) {
            case "post":
                return ( !empty($_POST) ) ? true : false;
            case "get":
                return ( !empty($_GET) ) ? true : false;
            default:
                return false;
            break;
        }
    }

    /**
     * Get field value by method
     *
     * @param string $field
     * @return string
     */
    public static function get ( string $field ) {
        if ( isset($_POST[$field]) ) {
            return $_POST[$field];
        } else if ( isset($_GET[$field]) ) {
            return $_GET[$field];
        }
        return "";
    }
}