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
function add_user ( $email, $password ) {

    $sql = "INSERT INTO users ( email, password ) VALUES ( :email, :password )";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql );
    $stmt->execute([
            'email'    => $email,
            'password' => password_hash( $password, PASSWORD_DEFAULT ),
    ]);

    return $pdo->lastInsertId();
}

/**
 * Edit user information
 *
 * @param string $fullname
 * @param string $position
 * @param string $phone
 * @param string $address
 * @param int $user_id
 * @return boolean
 */
function edit_user_information ( $fullname, $position, $phone, $address, $user_id ) {

    $sql = "UPDATE users SET fullname = :fullname, position = :position, phone = :phone, address = :address WHERE users.id = $user_id";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql );
    $stmt->execute([
            'fullname' => $fullname,
            'position' => $position,
            'phone'    => $phone,
            'address'  => $address,
    ]);
}

/**
 * Update database values by user id
 *
 * @param string $table
 * @param array $fields
 * @param int $user_id
 * @return void
 */
function update_query_by_id ( string $table, array $fields, $user_id ) {

    $fieldString = '';

    foreach($fields as $key => $value ) {
        $fieldString .= $key . '=:' . $key . ', ';
    }

    $fieldString = trim( $fieldString); // delete spaces
    $fieldString = rtrim( $fieldString, ','); // delete last comma

    $sql = "UPDATE {$table} SET {$fieldString} WHERE id={$user_id}";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql );
    $stmt->execute( $fields );

}

/**
 * Set user status
 *
 * @param string $status
 * @param integer $user_id
 * @return void
 */
function set_status ( $status, $user_id ) {
    $sql = "UPDATE users SET status = :status WHERE users.id = $user_id";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql );
    $stmt->execute([
            'status' => $status,
    ]);
}

/**
 * Upload user avatar image
 *
 * @param array $image
 * @param integer $user_id
 * @return void
 */
function upload_avatar ( $image, $user_id ) {

    // Check file size. MAX size 2mg
    if ( $image['size'] > 2097152 ) {
        set_flash_message('danger', 'Файл должен быть не более 2мб');
        redirect_to('../create_user.php');
    }

    $folder = 'uploads/';
    $file_extention =  pathinfo( $image['name'], PATHINFO_EXTENSION ); // return file extention => 'jpg'

    // Check for correct file extention
    $allowed_extentions = ['jpeg', 'jpg', 'png', 'svg', 'webp'];
    if ( !in_array( $file_extention, $allowed_extentions)) {
        set_flash_message('danger', 'Файл должен быть в формате .jpg, .jpeg, .png, .webp или .svg');
        redirect_to('../create_user.php');
    }

    // New file name 
    $new_file_name = str_replace( '.' . $file_extention, '', $image['name']) . "-" . rand() . "-" . time() . '.' . $file_extention;
    
    // Directories
    $uploaded_path = $image["tmp_name"];
    $save_file_path = $folder . $new_file_name;

    // Move file to UPLOADS directory
    move_uploaded_file($uploaded_path, '../' . $save_file_path );

    // Update image url in database
    update_query_by_id( 'users', ['image' => $save_file_path], $user_id );


}

/**
 * Delete file from server by given file path
 *
 * @param string $file_path
 * @return boolean
 */
function delete_file_from_server ( string $file_path ) {
    if ( !unlink($file_path)) {
        return false;
    }
    return true;
}

/**
 * User user social links
 *
 * @param string $telegram
 * @param string $instagra
 * @param string $vk
 * @param integer $user_id
 * @return void
 */
function add_social_links ( $telegram, $instagram, $vk, $user_id ) {

    $sql = "UPDATE users SET telegram = :telegram, instagram = :instagram, vk = :vk WHERE users.id = $user_id";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql );
    $stmt->execute([
            'telegram' => $telegram,
            'instagram' => $instagram,
            'vk'       => $vk,
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
        return false;
    }

    delete_password_from_array($user); // Delete hashed password from array (for security)

    $_SESSION['auth'] = $user;
    return true;
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
 * Check user role if user is admin
 *
 * @return boolean
 */
function is_admin() {
    if ( $_SESSION['auth']['role'] == 'admin' ) {
        return true;
    }
    return false;
}

/**
 * Check if current user is author of editable user
 *
 * @param integer $logged_user_id
 * @param integer $edit_user_id
 * @return boolean
 */
function is_author( $logged_user_id, $edit_user_id) {

    if ( $logged_user_id == $edit_user_id ) {
        return true;
    }
    return false;
}

/**
 * Get user by id
 *
 * @param integer $id
 * @return array
 */
function get_user_by_id(int $id) {

    $sql = "SELECT * FROM users WHERE id={$id}";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql ); 
    $stmt->execute();
    $result = $stmt->fetch( PDO::FETCH_ASSOC );

    delete_password_from_array($result); // Delete hashed password from array (for security)

    return $result;

}

/**
 * Get all rows from database by specific table
 *
 * @return array $users
 */
function get_all( $table ) {
    $sql = "SELECT * FROM {$table}";

    $pdo = pdo_connection (); // Connect to the database function

    $stmt = $pdo->prepare( $sql ); 
    $stmt->execute();
    $result = $stmt->fetchAll( PDO::FETCH_ASSOC );

    delete_password_from_array($result); // Delete hashed password from array (for security)

    return $result;
}

/**
 * Function that delete password item from array
 *
 * @param array $arr
 * @return void
 */
function delete_password_from_array( array $arr) {

    if ( isset($arr['password']) ) {
        unset( $arr['password'] ); // Delete hashed password from array (for security)
    }
}

/**
 * Function that return true if it ADMIN or USER ID is equals to SESSION authorisation ID
 *
 * @param integer $user_id
 * @return boolean
 */
function show_all_to_admin_or_one_to_user( int $user_id ) {
    if ( is_admin() || $_SESSION['auth']['id'] == $user_id ) {
        return true;
    }
    return false;
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

/**
 * Security check if POST global variable is set, if not ther redirect to given path
 *
 * @param $_POST $post
 * @param string $redirect_to
 * @return void
 */
function check_if_post_not_empty( $post, string $redirect_to) {

    if ( empty($_POST) ) {

        set_flash_message('danger', "<strong>Уведомление!</strong> Этот файл недоступен.");
        redirect_to ( $redirect_to );
        die;

    }
}