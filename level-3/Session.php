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

    /**
     * Set FLASH message to SESSION or return FLASH message
     *
     * @param string $name
     * @param string $message
     * @return string
     */
    public static function flash ( string $name, string $message = "") {
        if ( self::exists($name) && self::get($name) !== "" ) {
            $sesion = self::get($name);
            self::delete( $name );
            return $sesion;
        } else {
            self::put( $name, $message );
        }
    }
}