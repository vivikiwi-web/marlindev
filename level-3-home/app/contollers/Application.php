<?php 
class Application {

    public $pdo;

	public function __construct() {
		$this->pdo = DB::getInstance();
	}

}