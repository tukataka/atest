<?php

use App\Controllers\SaveController;
use App\Controllers\GetController;
use App\Controllers\DeleteController;
use App\Controllers\SearchController;

/** @var \League\Route\Router $router */
$router->map(
    'POST',
    '/document/{id:number}',
    SaveController::class
);

$router->map(
    'GET',
    '/document/{id:number}',
    GetController::class
);

$router->map(
    'DELETE',
    '/document/{id:number}',
    DeleteController::class
);

$router->map(
    'GET',
    '/search',
    SearchController::class
);
