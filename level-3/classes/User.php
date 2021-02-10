<?php 

class User {
    private $db = null, $data, $user_session, $user_table;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->user_session = Config::get( "session.user_session" );
        $this->users_table = Config::get( "db_table.users_table.name" );
        $this->login_main_field = Config::get( "db_table.users_table.login_main_field" );
    }

    /**
     * Insert row to database
     *
     * @param array $fields
     */
    public function create ( array $fields = [] ) {
        $this->db->insert( $this->users_table, $fields );
    }

    /**
     * Login user method
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function login ( string $email = "", string $password = "" ) {
        if ($email) {

            $user = $this->first( $email );

            if ( $user ) {
                if ( password_verify( $password, $this->data()->password ) ) {
                    Session::put($this->user_session, $this->data()->id );
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Find first row in search table
     *
     * @param string $email
     * @return boolean
     */
    public function first ( string $email ) {
        $this->data = $this->db->get( $this->users_table, [$this->login_main_field, "=", $email] )->first();
        return true;
    }

    /**
     * Return first row SQL query object
     *
     * @return object
     */
    public function data() {
        return $this->data;
    }
}