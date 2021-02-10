<?php 

class User {
    private $db = null, $data, $user_session, $users_table, $isLoggedIn;

    public function __construct( $user = "" ) {
        $this->db = Database::getInstance();
        $this->user_session = Config::get( "session.user_session" );
        $this->users_table = Config::get( "db_table.users_table.name" );
        $this->login_main_field = Config::get( "db_table.users_table.login_main_field" );

        if ( !$user ) {

            if ( Session::exists( $this->user_session ) ) {
                $user = $this->first(Session::get($this->user_session) );
                
                if ( $user ) {
                    $this->isLoggedIn = true;
                } else {
                    // logout
                }
            }

        } else {
            $user = $this->first($user );
        }
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
     * Find first row in search table by ID or Main field
     *
     * @param string|integer $value
     * @return boolean
     */
    public function first ( $value ) {

        // If value is numeric then find by id else by main field
        if ( is_numeric( $value ) ) {
            $this->data = $this->db->get( $this->users_table, ["id", "=", $value] )->first();
            return true;
        } else {
            $this->data = $this->db->get( $this->users_table, [$this->login_main_field, "=", $value] )->first();
            return true;
        }
        return false;
    }

    /**
     * Return first row SQL query object
     *
     * @return object
     */
    public function data() {
        return $this->data;
    }

    public function isLoggedIn () {
        return $this->isLoggedIn;
    }
}