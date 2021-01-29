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

    $sql = "SELECT id FROM users WHERE email=:email";

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
 * @param string $name
 * @return void
 */
function display_flash_message ( $key ) {
    
    if ( isset( $_SESSION[ $key ] ) ) :

        echo "<div class=\"alert alert-{$key}\">{$_SESSION[ $key ]}</div>";
        unset( $_SESSION[ $key ] );

    endif;
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