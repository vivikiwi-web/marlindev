<?php

require_once "helpers.php";
require_once "Database.php";
require_once "Config.php";
require_once "Input.php";
require_once "Validate.php";

$GLOBALS["config"] = [
    "mysql" => [
        "host" => "localhost",
        "username" => "root",
        "password" => "root",
        "dbname" => "marlindev_3level",
    ]
];

$pdo = Database::getInstance();

if ( Input::exists() ) {
    
    $validate = new Validate;

    $validation = $validate->check( $_POST, [
        "username" => [
            "required" => true,
            "min" => 2,
            "max" => 15,
            "unique" => "users"
        ],
        "password" => [
            "required" => true,
            "min" => 2,
            "max" => 15,
        ],
        "repeat_password" => [
            "required" => true,
            "matches" => "password"
        ]
    ]);

    if ( $validation->passed() ) {
        echo "passed";
    } else {
        foreach ( $validation->errors() as $errorMessage ) {
            echo $errorMessage . "<br />";
        }
    }
}

?>
<form action="" method="post">
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo Input::get('username'); ?>">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" name="password" value="">
    </div>
    <div>
        <label for="repeat_password">Repeat Password</label>
        <input type="text" name="repeat_password" value="">
    </div>
    <input type="submit" value="Submit">
</form>

<!-- // $pdo->update( "users", 5, ["username"=>"sania","password"=>"password2"]);
// $pdo->insert( "users", ["username"=>"valia","password"=>"password"]);
// $users = $pdo->query( "SELECT * FROM users WHERE username IN (?,?)", ["vitalij", "zulik"] );
// $users = $pdo->get( "users", ["username", "=", "vitalij"] )->count();
// $users = $pdo->get( "users", ["username", "=", "vitalij"] );
// $users = $pdo->delete( "users", ["username", "=", "test"] );


// $users = $pdo->query( "SELECT * FROM users");

// echo $users->first()->username;

// echo Config::get('mysql.dbname');

// echo $users;
// if ( $users->errors() ) {
//     echo "something goes wrong";
// } else {
//     foreach ( $users->results() as $user ) {
//         echo $user->username . "<br />";
//     }
// } -->