<?php

class HomeController extends Application {
    
	public function __construct() {
		parent::__construct();
	}

	public function indexAction( array $queryParams = [] ) {
        $users = $this->pdo->getAll("users")->results();
		include ROOT . "app/views/index.view.php";
	}

}