<?php

class UserController extends Application {

	public function __construct() {
		parent::__construct();
	}

	public function addAction() {
		include ROOT . "app/views/user/add.view.php";
	}



    public function createAction() {
        $this->pdo->insert( "users", [
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "password" => $_POST["password"],
            // "password_repeat" => $_POST["password_repeat"],
        ] );
    }

}