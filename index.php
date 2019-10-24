<?php

namespace Api;

require __DIR__ . '/vendor/autoload.php';


// -------- Uses
    use Api\Util\Util;
    use Api\Response\{HttpStatus, Response};
    use Api\Router\{Router};
    use Api\Models\User\{User};
    use Api\Request\{Request};
    use Api\Database\{Database};



// -------- Router and Request class
    $router = new Router();
    $res = new Request();



// -------- Routes
    // Main
    $router->get('.*', function () use ($res) {
        Response::output(HttpStatus::SUCCESS, $res->getParams());
    });

    // Get Users
    $router->post('users', function () use ($res) {

    });

    $router->get('users(/{\d+})?', function () use ($res) {
        echo "Get user(s): " . $res->ola ?? '';
    });

    $router->post('teste/{\w+}', function ($params) use ($res) {
        echo "POST require!<br>";
        var_dump($params);
    });


// -------- Running App
    $router->run();
