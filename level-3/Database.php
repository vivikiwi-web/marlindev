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

    public static function getInstance () {
        if ( !isset(self::$instance) ) {
            self::$instance = new Database;
        }
        return self::$instance;
    }

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

    public function get ( string $table, array $where ) {
        // dnd($table);
        return $this->action( "SELECT *", $table, $where);
    }

    public function first () {
        return $this->results()[0];
    }

    public function delete ( string $table, array $where ) {
        return $this->action( "DELETE", $table, $where);
    }

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

    public function errors () {
        return $this->errors;
    }

    public function results () {
        return $this->results;
    }

    public function count () {
        return $this->count;
    }
}