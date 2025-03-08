<?php

use App\Controllers\MainController;
use App\Core;

/** Debug */
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);

require('../vendor/autoload.php');

try {
    (new Core\App())
        ->connectDb('sqlite:../data/database.sqlite')
        ->addRoute(Core\Request::METHOD_GET, '/', MainController::class, 'index')
        ->addRoute(Core\Request::METHOD_POST, '/getStatistics', MainController::class, 'getStatistics')
        ->resolve();
} catch (Exception $e) {
    return http_response_code(404);
}
