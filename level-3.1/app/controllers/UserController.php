<?php

namespace App\Controllers;

use App\Models\User;
use League\Plates\Engine;
use \Tamtamchik\SimpleFlash\Flash;

class UserController
{
    private $userModel, $plate;

    public function __construct( User $userModel, Engine $plate )
    {
        $this->userModel = $userModel;
        $this->plate = $plate;
    }

    public function indexAction($vars = [])
    {
        // Get all users from model Users
        // $users = $this->userModel->getUsers("users");

        // flash()->error($data);

        // Render a template
        $this->plate->addFolder('layouts', ROOT . '/app/views/layouts');
        echo $this->plate->render('register',);
    }

    public function registerAction()
    {
        $newUser = $this->userModel->register( $_POST );
        $selector = $this->userModel->getSelector();
        $token = $this->userModel->getToken();

        $verificationURL = "<a href='".URL . '/verification/' . \urlencode($selector) . '/' . \urlencode($token)."'>Verificate your account</a>";

        flash()->success($verificationURL);

        // Render a template
        $this->plate->addFolder('layouts', ROOT . '/app/views/layouts');
        echo $this->plate->render('register');
    }

    public function verificationAction ( $params = [] ) {
        d($params);
    }
}
