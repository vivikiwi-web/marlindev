<?php 

/**
 * Connect to the database via PDO
 *
 * @return object PDO
 */
function pdo_connection () {
    return new PDO("mysql:host=localhost;dbname=marlindev_2level_1task", 'root', 'root' );
}

/**
 * User search in database by email
 *
 * @param string $email
 * @return array $user
 */
function get_user_by_email( $email ) {

    $sql = "SELECT * FROM users WHERE email=:email";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql ); 
    $stmt->execute( ["email" => $email] );
    $user = $stmt->fetch( PDO::FETCH_ASSOC );
    return $user;
}

/**
 * Add uset to database
 *
 * @param string $email
 * @param string $password
 * @return int $user_id
 */
function add_email ( $email, $password ) {

    $sql = "INSERT INTO users ( email, password ) VALUES ( :email, :password )";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql );
    $stmt->execute([
            'email'    => $email,
            'password' => password_hash( $password, PASSWORD_DEFAULT ),
    ]);
}

/**
 * Prepare flash message with $_SESSION
 *
 * @param string $name
 * @param string $message
 * @return void
 */
function set_flash_message( $name, $message ) {
    $_SESSION[ $name ] = $message;
}

/**
 * Display flash message with $_SESSION
 *
 * @param string || array $name
 * @return void
 */
function display_flash_message ( $key ) {

    // If $key is array
    if ( is_array( $key ) ) {
        foreach( $key as $k) {
            if ( isset( $_SESSION[ $k ] ) ) {
                echo "<div class=\"alert alert-{$k}\">{$_SESSION[ $k ]}</div>";
                unset( $_SESSION[ $k ] );
            }
        }
        return;
    }
    
    if ( isset( $_SESSION[ $key ] ) ) {
        echo "<div class=\"alert alert-{$key}\">{$_SESSION[ $key ]}</div>";
        unset( $_SESSION[ $key ] );
        return;
    }
}

/**
 * Redirect user to other link
 *
 * @param string $path
 * @return void
 */
function redirect_to ( $path ) {
    header( "Location: {$path}" );
}

/**
 * User authorisation
 *
 * @param string $email
 * @param string $password
 * @return boolean
 */
function login( $email, $password ) {

    $user = get_user_by_email( $email );

    if ( empty( $user ) || !password_verify( $password, $user['password'] ) ) {
        set_flash_message('danger', "Введены не правельные данные. Попробыйте еще раз.");
        return false;
    }

    unset($user['password']); // Delete hashed password from array (for security)

    $_SESSION['auth'] = $user;
    return true;
}

/**
 * Check if user is not logged in
 *
 * @return boolean
 */
function is_usert_not_logged_in() {
    if ( !isset($_SESSION['auth']) ) {
        return true;
    }

    return false;
}

/**
 * Logout user
 *
 * @return void
 */
function logout() {
    unset($_SESSION['auth']);
}

/**
 * Function for develompent, returns var_dumo in PRE tag
 *
 * @param any $val
 * @return void
 */
function dnd( $val ) {
    echo "<pre>";
    var_dump( $val );
    echo "</pre>";
    die;
}