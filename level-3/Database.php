<?php

class Database {
    private static $instance = null;
    private $pdo, $query, $errors = false, $results, $count;

    private function __construct () {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=marlindev_3level', 'root','root');
        } catch ( PDOException $e ) {
            die( 'Error: ' . $e->getMessage() );
        }
    }

    /**
     * Instance of Database class
     *
     * @return void
     */
    public static function getInstance () {
        if ( !isset(self::$instance) ) {
            self::$instance = new Database;
        }
        return self::$instance;
    }

    /**
     * SQL query method witch excecute SQL queries
     *
     * @param string $sql
     * @param array $params
     * @return Database
     */
    public function query ( string $sql, array $params = [] ) {

        $this->errors = false;
        $this->query = $this->pdo->prepare( $sql );

        if ( count($params) ) {
            $i = 1;
            foreach ( $params as $param ) {
                $this->query->bindValue( $i, $param );
                $i++;
            }
        }

        if ( !$this->query->execute() ) {
            $this->errors = true;
        } else {
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }
        return $this;
    }

    /**
     * Get all from database with WHERE parameters
     *
     * @param string $table
     * @param array $where
     * @return void
     */
    public function get ( string $table, array $where ) {
        // dnd($table);
        return $this->action( "SELECT *", $table, $where);
    }

    /**
     * Return first element from database query result
     *
     * @return void
     */
    public function first () {
        return $this->results()[0];
    }

    /**
     * Delete row in databse
     *
     * @param string $table
     * @param array $where
     * @return void
     */
    public function delete ( string $table, array $where ) {
        return $this->action( "DELETE", $table, $where);
    }

    /**
     * Insert row to databse
     *
     * @param string $table
     * @param array $params
     * @return void
     */
    public function insert ( string $table, array $params ) {

        $values = "";
        foreach ( $params as $param ) {
            $values .= "?,";
        }
        $values = rtrim( $values, "," );

        $columns = "";
        foreach ($params as $column => $value ) {
            $columns .= $column . ',';
        }
        $columns = rtrim( $columns, "," );

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";

        // dnd($sql);

        if ( !$this->query( $sql, $params )->errors() ) {
            return true;
        }
        return false;
    }

    /**
     * Update row in database
     *
     * @param string $table
     * @param integer $id
     * @param array $params
     * @return void
     */
    public function update ( string $table, int $id, array $params ) {

        $values = "";
        foreach ( $params as $column => $value ) {
            $values .= $column . "=?,";
        }
        $values = rtrim( $values, "," );

        $sql = "UPDATE {$table} SET {$values} WHERE id={$id}";

        if ( !$this->query( $sql, $params )->errors() ) {
            return true;
        }
        return false;
    }

    /**
     * Convert variables to SQL query string and pas it in query() method
     *
     * @param string $action
     * @param string $table
     * @param array $where
     * @return void
     */
    private function action ( string $action, string $table, array $where ) {

        if ( count($where === 3) ) {

            $operators = ["=", "<", ">", "<=", ">="];
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if ( in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if ( !$this->query( $sql, [$value] )->errors() ) {
                    return $this;
                }
            }
        }
        return false;

    }

    /**
     * Return error truea or false of database query result
     *
     * @return boolean
     */
    public function errors () {
        return $this->errors;
    }

    /**
     * Return object of database query result
     *
     * @return Database
     */
    public function results () {
        return $this->results;
    }

    /**
     * Return row count of database query result
     *
     * @return integer
     */
    public function count () {
        return $this->count;
    }
}