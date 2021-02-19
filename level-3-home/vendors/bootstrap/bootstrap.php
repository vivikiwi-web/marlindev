<?php

// Autoload classes
spl_autoload_register("autoload");

// // Autoload function 
function autoload ( $className ) {
    if ( file_exists( ROOT . "vendors/{$className}/{$className}.php" ) ) {
        require ROOT . "vendors/{$className}/{$className}.php";
    } elseif ( file_exists( ROOT . "app/contollers/{$className}.php" ) ) {
        require ROOT . "app/contollers/{$className}.php";
    } elseif ( file_exists( ROOT . "app/models/{$className}.php" ) ) {
        require ROOT . "app/models/{$className}.php";
    }
}