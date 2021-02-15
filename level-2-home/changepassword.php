<?php
session_start();

require_once "init.php";
$currentUser = new User;
$validate = new Validate;
$editUser = Input::get( 'id');

// Check if user logged in
if ( !$currentUser->isLoggedIn() ) {
  Redirect::to("index.php");
  exit;
}

$editProfile = $currentUser; // Set user Object. This $editProfile will be editable for all roles

// Check if same User and User don't have Admin permissions
if ( !$currentUser->hasPermissions("admin") ) {
  if ( $currentUser->data()->id !== $editUser) {
    Redirect::to("index.php");
    exit;
  }
} else {
  $editUser = new User( $editUser );
  $editProfile = $editUser; // Set new user Object.
}


if ( Input::exists() ) {

  if ( Token::check( Input::get('token') ) ) {

    $validate->check( $_POST, [
      "current_password" => [
        "required" => true,
        "min"      => 5
      ],
      "new_password" => [
        "required" => true,
        "min"      => 5
      ],
      "new_password_agean" => [
        "required" => true,
        "min"      => 5,
        "matches"   => "new_password"
      ],
    ]);

    if ( $validate->passed() ) {

      $oldPassword = $editProfile->data()->password;
      $currentPassword = Input::get( "current_password" );

      if ( password_verify( $currentPassword, $oldPassword  ) ) {

        $editProfile->update([ 
          "password" => password_hash( Input::get( "new_password" ), PASSWORD_DEFAULT )
        ], $editProfile->data()->id );
  
        Session::put("success", "Пароль обновлен.");

      } else {
        Session::put("wrong-password", "Текущий пароль неверный.");
      }
    }

  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="http://localhost/marlindev/level-3-home">User Management</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="http://localhost/marlindev/level-3-home/index.php">Главная</a>
          </li>
          <?php if ( $currentUser->hasPermissions("admin") ) : ?>
            <li class="nav-item">
              <a class="nav-link" href="users/index.php">Управление пользователями</a>
            </li>
          <?php endif; ?>
        </ul>

        <ul class="navbar-nav">
          
          <?php if ( $currentUser->isLoggedIn() ) : ?>
            <li class="nav-item">
              <a href="profile.php?id=<?php echo $currentUser->data()->id; ?>" class="nav-link active">Профель</a>
            </li>
            <li class="nav-item">
              <a href="logout.php" class="nav-link">Выйти</a>
            </li>
          <?php else :?>
            <li class="nav-item">
              <a href="login.php" class="nav-link">Войти</a>
            </li>
            <li class="nav-item">
              <a href="register.php" class="nav-link">Регистрация</a>
            </li>
          <?php endif; ?>

        </ul>
      </div>
    </nav>

   <div class="container">
     <div class="row">
       <div class="col-md-8">
         <h1>Изменить пароль</h1>
         
         <?php if ( Session::exists("success") ) : ?>
         <div class="alert alert-success"><?php echo Session::flash("success"); ?></div>
         <?php endif; ?>
         
         <?php if ( Session::exists("wrong-password") ) : ?>
         <div class="alert alert-info"><?php echo Session::flash("wrong-password"); ?></div>
         <?php endif; ?>

        <?php if ( $validate->errors() ) : ?> 
        <div class="alert alert-danger">
          <ul>
            <?php foreach ( $validate->errors() as $error ) ?>
            <li><?php echo $error; ?></li>
            <?php ?>
          </ul>
        </div>
        <?php endif; ?>

         <ul>
           <li><a href="profile.php?id=<?php echo $editProfile->data()->id; ?>">Изменить профиль</a></li>
         </ul>
         <form action="" method="post" class="form">
           <div class="form-group">
             <label for="current_password">Текущий пароль</label>
             <input type="password" name="current_password" id="current_password" class="form-control">
           </div>
           <div class="form-group">
             <label for="current_password">Новый пароль</label>
             <input type="password" name="new_password" id="current_password" class="form-control">
           </div>
           <div class="form-group">
             <label for="current_password">Повторите новый пароль</label>
             <input type="password" name="new_password_agean" id="current_password" class="form-control">
           </div>

           <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

           <div class="form-group">
             <button class="btn btn-warning" type="submit">Изменить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>