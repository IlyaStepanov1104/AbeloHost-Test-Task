<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$router = new App\Core\Router();

require_once dirname(__DIR__) . '/config/routes.php';

$router->dispatch();
