<?php

namespace Api\Controllers\Auth;

use Api\Models\User\User;
use Api\Util\Util;

class AuthController
{
    public static function login()
    {
        global $req;
        
        $user = new User();
        $user->setEmail($req->params->email)
            ->setPassword($req->params->password)
            ->findByParams();
        Util::sd($user);
    }
}