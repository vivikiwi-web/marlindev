<?php
session_start();

require_once "init.php";
$pdo = Database::getInstance();
$validate = new Validate;

if ( Input::exists() ) {

  if ( Token::check( Input::get("token" ) ) ) {
    
    $validate->check( $_POST, [
      "email" => [
        "required" => true,
        "email"    => true,
      ],
      "password" => [
        "required" => true,
        "min"    => 5,
      ]
    ] );

    

    if ( $validate->passed() ) {

      $user = new User;
      $remember = ( Input::get("remember_me") == "on") ? true : false;
      $email = Input::get("email");
      $password = Input::get("password");

      $login = $user->login( $email, $password, $remember);

      if ($login) {
        Redirect::to('index.php');
      } else {
        Session::put( "alert-info", "Логин или пароль неверны." );
      }

    }

  }

}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" action="" method="post">
    	  <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    	  <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>

        <?php if ( $validate->errors() ) : ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach( $validate->errors() as $error ) : ?>
              <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if ( Session::exists('alert-info') ) : ?>
          <div class="alert alert-info">
            <?php echo Session::flash( 'alert-info' ); ?>
          </div>
        <?php endif; ?>

    	  <div class="form-group">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
        </div>

    	  <div class="checkbox mb-3">
    	    <label>
    	      <input type="checkbox" name="remember_me"> Запомнить меня
    	    </label>
    	  </div>
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    	  <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    	  <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
