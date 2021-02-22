<?php

namespace Core;

class DB {
    public static $instance = null;

    /**
     * Connet to the database
     */
    public static function make() {

        try {
            $host = CONNECTION;
            $dbname = DB_NAME;
            $username = DB_USER;
            $password = DB_PASSWORD;
            $charset = DB_CHARSET;
            return new \PDO("{$host};dbname={$dbname};charset={$charset}", $username,$password);
        } catch ( \PDOException $e ) {
            die( 'Error: ' . $e->getMessage() );
        }
    }

    /**
     * Instance of Database class
     */
    public static function getInstance () {
        if ( !isset(self::$instance) ) {
            self::$instance = self::make();
        }
        return self::$instance;
    }

}