<?php 
session_start();

require_once "init.php";
    
$validate = new Validate;

if ( Input::exists() ) {

  if ( Token::check( Input::get("token") ) ) {

    $validate->check( $_POST, [
      "email" => [
        "required" => true,
        "email" => true,
        "min" => 5,
        "unique" => "users"
      ],
      "name" => [
        "required" => true,
        "min" => 2
      ],
      "password" => [
        "required" => true,
        "min" => 5,
      ],
      "password_agean" => [
        "required" => true,
        "min" => 5,
        "matches" => "password"
      ],
      "i_agree" => [
        "required" => true,
      ]
    ] );

    if ( $validate->passed() ) {
      
      $user = new User;

      $user->create([
        "name" => Input::get("name" ),
        "email" => Input::get("email" ),
        "date" => date("Y-m-d"),
        "password" => password_hash( Input::get("password" ), PASSWORD_DEFAULT ),
        "group_id" => 1,
      ]);

      Session::put( "success", "Зарегистрировались успешно. <a href='login.php'>Присоеденится</a>");

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
    <form class="form-signin" method="post" action="">
    	  <img class="mb-4" src="images/apple-touch-icon.png" alt="" width="72" height="72">
    	  <h1 class="h3 mb-3 font-weight-normal">Регистрация</h1>

        <?php if ( $validate->errors() ) : ?>
        <div class="alert alert-danger">
          <ul>
            <?php foreach( $validate->errors() as $error ) : ?>
            <li><?php echo $error; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if ( Session::exists( "success" ) ) : ?>
          <div class="alert alert-success">
            <?php echo Session::flash( "success" ); ?>
          </div>
        <?php endif; ?>
<!-- 
        <div class="alert alert-info">
          Информация
        </div> -->

          <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Ваше имя">
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Пароль">
          </div>
          
          <div class="form-group">
            <input type="password" class="form-control" name="password_agean" placeholder="Повторите пароль">
          </div>

          <div class="checkbox mb-3">
            <label>
              <input type="checkbox" name="i_agree"> Согласен со всеми правилами
            </label>
          </div>
          <input type="hidden" name="token" value="<?php echo Token::generate(); ?>"/>
          <input type="submit" class="btn btn-lg btn-primary btn-block" value="Зарегистрироваться" />
          <p class="mt-5 mb-3 text-muted">&copy; 2017-2020</p>
    </form>
</body>
</html>
