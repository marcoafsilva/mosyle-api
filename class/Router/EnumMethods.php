<?php

namespace Api\Router;

use ReflectionClass;

class EnumMethods
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

    public static function isValid($method)
    {
        $reflection = new ReflectionClass(self::class);
        
        return $reflection->getConstant($method);
    }
}
