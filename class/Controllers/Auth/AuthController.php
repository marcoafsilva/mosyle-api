<?php

namespace Api\Controllers\Auth;

use Api\Models\User\User;
use Api\Response\HttpStatus;
use Api\Response\Response;
use Api\Token\Token;
use Api\Util\Util;

class AuthController
{
    public static function login()
    {
        global $req;
        
        $user = new User();
        $user->setEmail($req->params->email)
            ->setPassword($req->params->password);
        
        if ($find = $user->findByParams()) {
            return Response::output(
                HttpStatus::SUCCESS, 
                "{$find['rowCount']} usuário(s) encontrados.", 
                [
                    'user' => $find['payload'][0],
                    'token' => new Token()
                ]
            );
        }

        return Response::output(HttpStatus::NOT_FOUND, 'Usuário não encontrado.');

    }
}