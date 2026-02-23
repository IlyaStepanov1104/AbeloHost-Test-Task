<?php

/** @var App\Core\Router $router */

$router->get('/', 'IndexController', 'index');
$router->get('/posts', 'PostController', 'index');
$router->get('/category/:slug', 'CategoryController', 'show');
$router->get('/post/:slug', 'PostController', 'show');
$router->get('/random', 'PostController', 'random');
$router->get('/generate', 'GenerateController', 'generate');
