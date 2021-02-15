<?php
require_once "init.php";

$pdo = Database::getInstance();

if ( Input::exists() ) {
    
    if ( Token::check( Input::get( "token" ) )) {
        $validate = new Validate;
        $validate->check( $_POST, [
            "email" => [ "required" => true, "email" => true ],
            "password" => [ "required" => true ]
        ]);
    
        if ( $validate->passed() ) {
            $user = new User;

            $remember = ( Input::get('remember') == "on") ? true : false;
            $login = $user->login( Input::get("email" ), Input::get( "password"), $remember );

            if ( $login ) {
                Redirect::to('index.php');
            } else {
                echo "Login failed";
            }

        } else {
            foreach ( $validate->errors() as $errorMessage ) {
                echo $errorMessage . "<br />";
            }
        }
    }
}

?>

<form action="" method="post">
    <div>
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo Input::get("email"); ?>" />
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" name="password" value="" />
    </div>
    <div>
        <label for="remember">Remember Me</label>
        <input type="checkbox" name="remember" id="">
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
    <input type="submit" value="Submit">
</form>