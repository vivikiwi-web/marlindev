<?php

namespace App\Controllers;

use App\Models\User;
use League\Plates\Engine;

class DashboardController
{
    private $userModel, $plate;

    public function __construct( User $userModel, Engine $plate)
    {
        $this->userModel = $userModel;
        $this->plate = $plate;
    }

    public function indexAction( $vars = [] )
    {
        // $users = $query->insert( "users", $data ); // Insert
        // $users = $query->update( "users", $data, 4 ); // Update
        // $users = $query->delete( "users", 5 ); // Update

        // Get all users from model Users
        $users = $this->userModel->getUsers("users");

        // Add folders
        $this->plate->addFolder('dashboard', ROOT . '/app/views/dashboard');
        $this->plate->addFolder('dashboard_temp', ROOT . '/app/views/dashboard/layouts');

        // Render a template
        echo $this->plate->render('dashboard::dashboard', ["users" => $users]);
    }
}
