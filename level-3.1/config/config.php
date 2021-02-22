<?php

// Connection to database
define("CONNECTION", "mysql:host=localhost"); 
define("DB_NAME", "marlin3_db"); 
define("DB_USER", "root"); 
define("DB_PASSWORD", "root"); 
define("DB_CHARSET", "utf8"); 



define("ROOT", dirname(__FILE__, 2) ); // Remove "core" from URL and set global variable ROOT
define( "PROOT", "/marlindev/level-3.1"); // set to "/" if it on PRODUCTION
define( "URL", "http://localhost/marlindev/level-3.1"); // set to www address