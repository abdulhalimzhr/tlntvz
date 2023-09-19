<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'Env.php';
require_once 'Connection.php';

Env::load(__DIR__ . '/../.env');

include __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../config/database.php';

spl_autoload_register(function ($class) {
    $classPaths = [__DIR__ . '/../Models/',  __DIR__ . '/../Controllers/',  __DIR__ . '/../Middlewares/'];

    foreach ($classPaths as $path) {
        $classFile = $path . $class . '.php';
        if (file_exists($classFile)) {
            require $classFile;
            return;
        }
    }
});

require_once 'Router.php';
require_once __DIR__ . '/../config/router.php';

global $db;
$conn = new Connection($config);
$db = $conn::getConnection();

Router::handleRequest();
