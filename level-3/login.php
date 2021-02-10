<?php
require_once "init.php";

$pdo = Database::getInstance();

if ( Input::exists() ) {
    
    if ( Token::check( Input::get( 'token' ) )) {
        $validate = new Validate;
        $validation = $validate->check( $_POST, [
            "username" => [
                "required" => true,
                "min" => 2,
                "max" => 15,
                "unique" => "users"
            ],
            "password" => [
                "required" => true,
                "min" => 2,
                "max" => 15,
            ],
        ]);
    
        if ( $validation->passed() ) {
            Session::flash( 'success', 'Login success.');
        } else {
            foreach ( $validation->errors() as $errorMessage ) {
                echo $errorMessage . "<br />";
            }
        }
    } else {
        echo "wrong token";
    }
}

echo Session::flash( 'success' );

?>

<form action="" method="post">
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo Input::get('username'); ?>" />
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" name="password" value="" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
    <input type="submit" value="Submit">
</form>