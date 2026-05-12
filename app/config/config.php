<?php

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'liga_basquetbol');

// Application Constants
define('URL_BASE', 'http://localhost/ligabasket/public/');
define('APP_NAME', 'Liga de Básquetbol Pro');

// Load Helpers
require_once '../app/helpers/url_helper.php';

// Autoloading (simple version)
spl_autoload_register(function ($class_name) {
    $paths = [
        '../app/controllers/',
        '../app/models/',
        '../app/core/'
    ];

    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});
