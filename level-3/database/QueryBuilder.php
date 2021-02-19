<?php

class QueryBuilder {
    protected $pdo;

    public function __construct( $pdo )
    {
        $this->pdo = $pdo;
    }

    public function getAll( $table ) {
        $sql = "SELECT * FROM {$table}";
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create ( $table, $data ) {

        $keys = implode(",", array_keys($data));
        $values = ":" . implode(",:", array_keys($data));
        $sql = "INSERT INTO {$table} ({$keys}) VALUES ({$values})";
        $stnt = $this->pdo->prepare( $sql );
        $stnt->execute($data);

    }

    public function getOne( $table, $id ) {
        $sql = "SELECT * FROM {$table} WHERE id=:id";
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute([
            "id" => $id,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update ( $table, $data, $id ) {

        $string = "";

        foreach ( $data as $key => $values) {
            $string .= $key . "=:" . $key . ",";
        }

        $data["id"] = $id;

        $string = rtrim( $string, "," );

        $sql = "UPDATE {$table} SET {$string} WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
    }

    public function delete ( $table, $id ) {

        $sql = "DELETE FROM {$table} WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute( [
            "id" => $id
        ] );
    }

    
}