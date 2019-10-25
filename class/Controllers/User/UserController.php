<?php

namespace Api\Controllers\User;

use Api\Models\User\User;
use Api\Response\HttpStatus;
use Api\Response\Response;
use Api\Token\Token;
use Api\Util\Util;

class UserController
{
    
    public static function newUser()
    {
        global $req;
        
        $user = new User();
        $user->setName($req->params->name)
            ->setEmail($req->params->email)
            ->setPassword($req->params->password)
            ->save();
    }

    public static function editUser()
    {
        global $req;

        if (!Token::isValid($req->header->token)) {
            die('');
        }

        $user = new User($req->params->userId);
        $user->setName($req->params->name)
            ->setEmail($req->params->email)
            ->setPassword($req->params->password)
            ->save();
    }

    public static function getUser()
    {
        global $req;

        if (!Token::isValid($req->header->token)) {
            die('');
        }

        $user = new User($req->params->userId);
        $find = $user->get();
        
        return Response::output(
            HttpStatus::SUCCESS, 
            "{$find['rowCount']} usuário(s) encontrados.", 
            [
                'users' => $find['payload']
            ]
        );
    }

    public static function removeUser()
    {
        global $req;

        if (!Token::isValid($req->header->token)) {
            die('');
        }
        
        $user = new User($req->params->userId);
        $find = $user->remove();

        return Response::output(
            HttpStatus::SUCCESS, 
            "{$find['rowCount']} usuário(s) foram removidos."
        );
    }

    public static function drinkWater()
    {
        global $req;

        if (!Token::isValid($req->header->token)) {
            die('');
        }

        $user = new User($req->params->userId);
        $find = $user->drink($req->params->drink_ml);

        return Response::output(
            HttpStatus::SUCCESS, 
            "{$find['rowCount']} usuário(s) encontrados.", 
            [
                'users' => $find['payload']
            ]
        );
    }
}