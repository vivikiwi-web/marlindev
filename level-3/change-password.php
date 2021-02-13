<?php
require_once "init.php";

$user = new User;

if ( Input::exists() ) {

    if ( Token::check(Input::get("token")) ) {
        $validate = new Validate;
        $validate->check( $_POST,[
            "current_password"=> [ "required"=>true, "min"=>5 ],
            "new_password"=> [ "required"=>true, "min"=>5 ],
            "new_password_agean"=> [ "required"=>true, "min"=>5, "maches"=>true ],
        ]);
    
        if ( $validate->passed() ) {
            if ( password_verify( Input::get("current_password"), $user->data()->password ) ) {
                $user->update ( ["password" => password_hash(Input::get("new_password"), PASSWORD_DEFAULT) ] );
                Session::put("success", "Password has been changed.");
                Redirect::to("index.php");
            } else {
                echo "Password is invalid";
            }
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
        <label for="current_password">Current Password</label>
        <input type="text" name="current_password" value="" />
    </div>
    <div>
        <label for="new_password">New Password</label>
        <input type="text" name="new_password" value="" />
    </div>
    <div>
        <label for="new_password_agean">Repeat New Password</label>
        <input type="text" name="new_password_agean" value="" />
    </div>
    
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
    <input type="submit" value="Update">
</form>