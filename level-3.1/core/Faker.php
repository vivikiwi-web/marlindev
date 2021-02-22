<?php

namespace Core;

use Faker\Factory;
use App\Models\User;

class Faker {
    private $pdo, $query, $faker;

    public function __construct( User $userModel )
    {
        $this->userModel = $userModel;
        $this->faker = Factory::create();
    }
    

public function fakerUsers() {

    d( $this->faker->numberBetween(0,1));

    // d( $faker->date( $format = 'Y-m-d', $max = 'now') );
    // d( $faker->date($format = 'Y-m-d', $max = 'now') );
    // d( $faker->company );
    // d( $faker->words(3, true) );
    // d( $faker->numberBetween(300,3300));
    // d( $faker->numberBetween(0,1000));

    // Get all users from model Users
    $users = $this->userModel->getUsers("users");

    d( $users );
    
}

}