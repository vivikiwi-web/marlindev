<?php

class AboutController  {

	public function __construct($controller, $action) { // Duomenys perduodami iš Router::route
		
		
	}

	public function indexAction() {

		include ROOT . "app/views/about.view.php";
	}

}