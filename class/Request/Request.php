<?php

namespace Api\Request;

use Api\Router\EnumMethods;
use stdClass;

class Request
{
    public $header;
    public $params;

    public function __construct()
    {
        $this->header = (object)$this->getHeader();
        $this->params = (object)$this->getParams();
    }

    public function __get($name)
    {
        return $this->params[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->params->{$name} = $value;
        return $this;
    }

    public function listHeader()
    {
        return $this->header;
    }

    public function listParams()
    {
        return $this->params;
    }

    private function getHeader()
    {
        return getallheaders();
    }

    private function getParams()
    {
        $params = '';

        switch (strtoupper($_SERVER['REQUEST_METHOD'])) {
            case EnumMethods::GET:
                $params = $_GET;
                break;

            case EnumMethods::POST:
            case EnumMethods::PUT:
                $params = json_decode(file_get_contents('php://input'));
                break;

            default:
                $params = null;
                break;
        }

        return $params;
    }

    public function getRequest()
    {
        return $this->req;
    }
}
