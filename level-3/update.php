<?php
require_once "init.php";

$user = new User;

if ( Input::exists() ) {

    if ( Token::check(Input::get("token")) ) {
        $validate = new Validate;
        $validate->check( $_POST, ["username"=> ["required"=>true, "min"=>2]] );
    
        if ( $validate->passed() ) {
            $user->update ( ["username" => Input::get("username") ] );
            Redirect::to("update.php");
        } else {
            foreach ( $validate->errors() as $error ) {
                echo $error . "<br />";
            }
        }

    }
}

?>


<form action="" method="post">
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo $user->data()->username; ?>" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
    <input type="submit" value="Update">
</form>