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
      "name" => [
        "required" => true,
        "min"      => 2
      ]
    ]);

    if ( $validate->passed() ) {
      $editProfile->update([
        "name" => Input::get( "name" ),
        "status" => Input::get( "status" ),
      ], $editProfile->data()->id );

      Session::put("success", "Профиль обновлен.");
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
         <h1>Профиль пользователя - <?php echo $editProfile->data()->name; ?></h1>
         
         <?php if ( Session::exists("success") ) : ?>
         <div class="alert alert-success"><?php echo Session::flash("success"); ?></div>
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
           <li><a href="changepassword.php?id=<?php echo $editProfile->data()->id; ?>">Изменить пароль</a></li>
         </ul>
         <form action="" method="post" class="form">
           <div class="form-group">
             <label for="username">Имя</label>
             <input type="text" id="username" name="name" class="form-control" value="<?php echo $editProfile->data()->name; ?>">
           </div>
           <div class="form-group">
             <label for="status">Статус</label>
             <input type="text" id="status" name="status" class="form-control" value="<?php echo $editProfile->data()->status; ?>">
           </div>

           <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

           <div class="form-group">
             <button class="btn btn-warning" type="submit">Обновить</button>
           </div>
         </form>


       </div>
     </div>
   </div>
</body>
</html>