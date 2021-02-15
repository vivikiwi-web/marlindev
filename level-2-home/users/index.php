<?php
session_start();

require_once "../init.php";
$user = new User;
$pdo = Database::getInstance();


// // Check if user logged in and has permissions Admin
if ( !$user->isLoggedIn() ) {
  if ( !$user->hasPermissions("admin") ) {
    Redirect::to("../index.php");
    exit;
  }
}

$allUsers = $pdo->query( "SELECT * FROM users" )->results();

?>

<!doctype html>
<html lang="en">
  <head>
    <base href="http://localhost/marlindev/level-3-home/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Users</title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Custom styles for this template -->
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
            <a class="nav-link" href="http://localhost/marlindev/level-3-home">Главная</a>
          </li>
            <?php if ( $user->hasPermissions("admin") ) : ?>
              <li class="nav-item">
                <a class="nav-link" href="users/index.php">Управление пользователями</a>
              </li>
            <?php endif; ?>
        </ul>

        <ul class="navbar-nav">
          
          <?php if ( $user->isLoggedIn() ) : ?>
            <li class="nav-item">
              <a href="profile.php?id=<?php echo $user->data()->id; ?>" class="nav-link active">Профель</a>
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
      <div class="col-md-12">
        <h1>Пользователи</h1>
        
        <?php if ( Session::exists("success") ) : ?>
         <div class="alert alert-success"><?php echo Session::flash("success"); ?></div>
         <?php endif; ?>

        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Имя</th>
              <th>Email</th>
              <th>Действия</th>
            </tr>
          </thead>

          <tbody>

            <?php foreach( $allUsers as $user ) : ?>
            <tr>
              <td><?php echo $user->id; ?></td>
              <td><?php echo $user->name; ?></td>
              <td><?php echo $user->email; ?></td>
              <td>
              	<a href="users/set_role.php?id=<?php echo $user->id; ?>" class="btn btn-success" onclick="return confirm('Вы уверены?');">Назначить <?php echo ( $user->group_id == 1) ? "администратором" : "обычным"; ?></a>
                <a href="user_profile.php?id=<?php echo $user->id; ?>" class="btn btn-info">Посмотреть</a>
                <a href="profile.php?id=<?php echo $user->id; ?>" class="btn btn-warning">Редактировать</a>
                <a href="users/delete_user.php?id=<?php echo $user->id; ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?');">Удалить</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>  
  </body>
</html>
