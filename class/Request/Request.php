<?php

namespace Api\Request;

use Api\Router\EnumMethods;

class Request
{

    private $res;

    public function __construct()
    {
        switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
            case EnumMethods::GET:
                $this->res = $_GET;
                break;

            case EnumMethods::POST:
                $this->res = json_decode(file_get_contents('php://input'));
                break;

            default:
                $this->res = null;
                break;
        }
    }

    public function __get($name)
    {
        return $this->res->$name ?? null;
    }

    public function __set($name, $value)
    {
        $this->res->{$name} = $value;
        return $this;
    }

    public function getParams()
    {
        return $this->res;
    }
}
