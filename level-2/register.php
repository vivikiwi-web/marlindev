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
            ],
            "email" => [
                "required" => true,
                "email" => true,
                "unique" => "users"
            ],
            "password" => [
                "required" => true,
                "min" => 2,
                "max" => 15,
            ],
            "repeat_password" => [
                "required" => true,
                "matches" => "password"
            ]
        ]);
    
        if ( $validation->passed() ) {
            $user = new User;

            $user->create([
                'username' => Input::get('username'),
                'email' => Input::get('email'),
                'password' => password_hash( Input::get('password'), PASSWORD_DEFAULT )
            ]);

            Session::flash( 'success', 'Register successfull.');
        } else {
            foreach ( $validation->errors() as $errorMessage ) {
                echo $errorMessage . "<br />";
            }
        }
    } else {
        echo "wrong token";
    }
}

echo Session::flash("success");
?>

<form action="" method="post">
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo Input::get('username'); ?>" />
    </div>
    <div>
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo Input::get('email'); ?>" />
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" name="password" value="" />
    </div>
    <div>
        <label for="repeat_password">Repeat Password</label>
        <input type="text" name="repeat_password" value="" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
    <input type="submit" value="Submit">
</form>