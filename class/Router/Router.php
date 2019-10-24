<?php

namespace Api\Router;

use Api\Response\HttpStatus;
use Api\Response\Response;
use Api\Router\EnumMethods;

class Router
{
    private $routes = [];

    public function on($method, $path, $callback)
    {
        $method = strtoupper($method);

        if (!EnumMethods::isValid($method)) {
            $this->routes[$method] = [];
            echo "error";
        }

        $path = str_replace("/", "\/", $path);
        $path = str_replace(["{", "}"], ["",""], $path);
        $path = "/^" . $path . "$/";

        $this->routes[$method][$path] = $callback;

        return $this;
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = preg_replace("/\/mosyle-api\//i", "", $_SERVER['REQUEST_URI']);

        foreach ($this->routes[$method] as $route => $callback) {
            if (preg_match($route, $uri, $parameters)) {
                $parameters = explode("/", $parameters[0]);
                array_shift($parameters);
                return call_user_func_array($callback, $parameters);
            }
        }

        return Response::output(HttpStatus::NOT_FOUND);
    }

    public function __call($name, $arguments)
    {
        $this->on($name, $arguments[0], $arguments[1]);
    }
}
