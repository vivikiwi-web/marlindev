<?php

class Token {

    /**
     * Generate new unique token and add it to SESSION
     *
     * @return string
     */
    public static function generate () {
        return Session::put( Config::get('session.token_name' ), md5( uniqid() ));
    }

    /**
     * Check if token exist
     *
     * @param string $token
     * @return boolean
     */
    public static function check ( string $token ) {

        $tokenName = Config::get('session.token_name' );
        
        if ( Session::exists($tokenName) && $token == Session::get($tokenName) ) {
            Session::delete($tokenName);
            return true;
        }
        return false;
    }
}