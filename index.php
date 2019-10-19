<?php

namespace Api;

require __DIR__ . '/vendor/autoload.php';

use Api\Response\{HttpStatus, Response};
use Api\Router\{Router, EnumMethods};
use Api\Models\User\{User};

$router = new Router();

// Main
$router->on(EnumMethods::GET, '', function(){
    Response::output(HttpStatus::SUCCESS);
});

// Get Users
$router->on(EnumMethods::GET, 'users(/{\d+})?', function($userId = null){
    echo "Get user(s): " . $userId ?? '';
});


$router->on(EnumMethods::POST, 'teste/{\w+}', function($params){
    echo "POST require!<br>";
    var_dump($params);
});

$router->run();