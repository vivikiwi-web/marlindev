<?php

class Session {

    /**
     * Create SESSION by given name and value
     *
     * @param string $name
     * @param string $value
     * @return $_SESSION
     */
    public static function put ( $name, $value) {
        return $_SESSION[$name] = $value;
    }

    /**
     * Check if SESSION exist by given name
     *
     * @param string $name
     * @return boolean
     */
    public static function exists ( $name ) {
        return ( isset($_SESSION[$name]) ) ? true : false;
    }

    /**
     * Create SESSION by given name
     *
     * @param string $name
     */
    public static function delete ( $name ) {
        if ( self::exists($name) ) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Return SESSION value by given name
     *
     * @param string $name
     * @return string
     */
    public static function get ( $name ) {
        return $_SESSION[$name];
    }
}