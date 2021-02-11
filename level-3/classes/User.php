<?php 

class User {
    private $db = null, $data, $sessionName, $dbName, $mainField, $isLoggedIn;

    public function __construct( $user = "" ) {
        $this->db = Database::getInstance();
        $this->sessionName = Config::get( "session.user_session" );
        $this->dbName = Config::get( "db_table.users_table.name" );
        $this->mainField = Config::get( "db_table.users_table.login_main_field" );

        if ( !$user ) {

            if ( Session::exists( $this->sessionName ) ) {
                $user = $this->first(Session::get($this->sessionName) );
                
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
     * @return void
     */
    public function create ( array $fields = [] ) {
        $this->db->insert( $this->dbName, $fields );
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
                    Session::put($this->sessionName, $this->data()->id );
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Logout method, detele User session
     *
     * @return void
     */
    public function logout () {
        return Session::delete( $this->sessionName );
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
            $this->data = $this->db->get( $this->dbName, ["id", "=", $value] )->first();
            return true;
        } else {
            $this->data = $this->db->get( $this->dbName, [$this->mainField, "=", $value] )->first();
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

    /**
     * Return boolean where True is Logged in
     *
     * @return boolean
     */
    public function isLoggedIn () {
        return $this->isLoggedIn;
    }
}