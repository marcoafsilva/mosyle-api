<?php

namespace Api;

// -------- Composer autoload require
    require __DIR__ . '/vendor/autoload.php';
    
    
    // -------- Uses
    
    use Api\Util\Util;
    use Api\Response\{HttpStatus, Response};
    use Api\Router\{EnumMethods, Router};
    use Api\Request\{Request};
    use Api\Database\{Database};
    use Api\Controllers\Auth\AuthController;
    use Api\Controllers\User\UserController;
    
    
    
    // -------- Router, Request, Database classes
    $req = new Request();
    $router = new Router();
    $db = Database::getInstance();
    date_default_timezone_set('America/Sao_Paulo');

// -------- Routes
    // Main
    $router->get('', function () use ($req) {
        Response::output(HttpStatus::SUCCESS);
    });

    // Create new user
    $router->post('users', function () use ($req) {
        UserController::newUser();
    });

    // Login (Get token)
    $router->post('login', function () use ($req) {
        AuthController::login();
    });

    // Get user data
    $router->get('users(/{\d+})?', function ($userId = null) use ($req) {
        $req->userId = $userId;
        UserController::getUser();
    });

    // Edit user data
    $router->put('users/{\d+}', function ($userId) use ($req) {
        $req->userId = $userId;
        UserController::editUser();
    });

    // Remove user data
    $router->delete('users/{\d+}', function ($userId) use ($req) {
        $req->userId = $userId;
        UserController::removeUser();
    });

    // Register that user drink water
    $router->post('users/{\d+}/drink', function ($userId) use ($req) {
        $req->userId = $userId;
        UserController::drinkWater();
    });


// -------- Running App
    $router->run();
