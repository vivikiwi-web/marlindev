<?php 

class User {
    private $db = null, $data, $sessionName, $cookieName, $usersTable, $cookieTable, $isLoggedIn;

    public function __construct( $user = "" ) {
        $this->db = Database::getInstance();
        $this->sessionName  = Config::get( "session.user_session" );
        $this->cookieName   = Config::get( "cookie.cookie_name" );
        $this->usersTable   = Config::get( "db_table.users_table" );
        $this->cookieTable = Config::get( "db_table.coockie_table" );
        $this->groupTable = Config::get( "db_table.group_table" );

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
        $this->db->insert( $this->usersTable, $fields );
    }

    /**
     * Delete User from User table and Cookie tablee
     *
     * @param integer $id
     * @return void
     */
    public function delete ( $id ) {
        $this->db->delete( $this->usersTable, ["id", "=", $id]  );
        $this->db->delete( $this->cookieTable, ["user_id", "=", $id ] );
        // Session::delete( $editUser->sessionName );
    }

    /**
     * Login user method
     *
     * @param string $email
     * @param string $password
     * @param boolean $remember
     * @return boolean
     */
    public function login ( string $email = "", string $password = "", bool $remember = false ) {
        // if user have no email and password, but data() exists, then set SESSION, because user have COOKIE
        if ( !$email && !$password && $this->exists() ) {
            Session::put($this->sessionName, $this->data()->id );
        } else {
            $user = $this->first( $email );
            if ( $user ) {
                if ( password_verify( $password, $this->data()->password ) ) {
                    Session::put($this->sessionName, $this->data()->id );

                    // If uset checked REMEMBER ME checkbox
                    if ( $remember ) {
                        $hashCheck = $this->db->get( $this->cookieTable, ["user_id", "=", $this->data()->id] );
                        if ( !$hashCheck->count() ) {
                            $hash = hash( "sha256", uniqid() );
                            $this->db->insert( $this->cookieTable, [
                                "user_id" => $this->data()->id,
                                "hash"    => $hash
                            ] );
                        } else {
                            $hash = $hashCheck->first()->hash;
                        }
                        Cookie::put( $this->cookieName,$hash, Config::get( "cookie.cookie_expite" ) );
                    }
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
        $this->db->delete( $this->cookieTable, ["user_id", "=", $this->data()->id] );
        Session::delete( $this->sessionName );
        Cookie::delete( $this->cookieName );
    }

    /**
     * Update user information
     *
     * @param array $fields
     * @param integer $id
     * @return boolean
     */
    public function update ( array $fields = [], int $id = null ) {
        if ( !$id && $this->isLoggedIn() ) {
            $id = $this->data()->id;
        }
        return $this->db->update( $this->usersTable, $id, $fields );
    }

    public function exists () {
        return ( !empty($this->data() )) ? true : false;
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
            $this->data = $this->db->get( $this->usersTable, ["id", "=", $value] )->first();
            return true;
        } else {
            $this->data = $this->db->get( $this->usersTable, ["email", "=", $value] )->first();
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

    /**
     * Check user permissions
     *
     * @param string $key
     * @return boolean
     */
    public function hasPermissions ( string $key  ) {
        
        $group = $this->db->get( $this->groupTable, ['id', "=", $this->data()->group_id] );
    
        if ( $group->count() ) {
            $permissions = $group->first()->permissions;
            $permissions = json_decode( $permissions, true );
            
            if ( $permissions[ $key ] ) {
                return true;
            }
            return false;
        }

    }
}