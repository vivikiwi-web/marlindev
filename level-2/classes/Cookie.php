<?php

class Cookie {

    /**
     * Check if COOKIE exist by given name
     *
     * @param string $name
     * @return boolean
     */
    public static function exists ( string $name ) {
        return ( isset($_COOKIE[$name]) ) ? true : false;
    }

    /**
     * Return COOKIE value by given name
     *
     * @param string $name
     * @return string
     */
    public static function get ( string $name ) {
        return $_COOKIE[ $name ];
    }

    /**
     * Create SESSION by given name and value
     *
     * @param string $name
     * @param string $value
     * @param integer $expire
     * @return boolean
     */
    public static function put ( string $name, string $value, int $expire ) {
        if ( setcookie( $name, $value, time() + $expire, "/") ) {
            return true;
        }
        return false;
    }

    /**
     * Delete COOKIE by given name
     *
     * @param string $name
     * @return void
     */
    public static function delete ( string $name ) {
        self::put( $name, "", time() - 1 );
    }
}