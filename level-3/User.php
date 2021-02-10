<?php 

class User {
    private $db = null;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Insert user to dataabase
     *
     * @param array $fields
     */
    public function create ( array $fields = [] ) {
        $this->db->insert( 'users', $fields );
    }
}