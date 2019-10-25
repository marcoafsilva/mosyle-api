<?php

namespace Api;

// -------- Composer autoload require
    require __DIR__ . '/vendor/autoload.php';


// -------- Uses

    use Api\Util\Util;
    use Api\Response\{HttpStatus, Response};
    use Api\Router\{Router};
    use Api\Request\{Request};
    use Api\Database\{Database};
    use Api\Controllers\Auth\AuthController;
    use Api\Controllers\User\UserController;

    $db = Database::getInstance();


// -------- Router and Request class
    $router = new Router();
    $req = new Request();

// -------- Routes
    // Main
    $router->get('.*', function () use ($req) {
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

    $router->get('users(/{\d+})?', function () use ($req) {
        echo "Get user(s): " . $req->ola ?? '';
    });



// -------- Running App
    $router->run();
