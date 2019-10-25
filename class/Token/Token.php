<?php

namespace Api\Token;

use Api\Response\HttpStatus;
use Api\Response\Response;

class Token
{
    const TOKEN_INTERVAL = (5*60);
    public $token;

    public function __construct()
    {
        return $this->token = base64_encode(time() + self::TOKEN_INTERVAL);
    }

    public static function isValid($token)
    {
        $decodedToken = base64_decode($token, true);

        if (time() > $decodedToken) {
            return Response::output(HttpStatus::INVALID_REQUISITION, 'Token inválido ou expirado!');
        }

        return true;
    }
}