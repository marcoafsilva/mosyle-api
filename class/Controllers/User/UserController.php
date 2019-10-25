<?php

namespace Api\Controllers\User;

use Api\Models\User\User;
use Api\Util\Util;

class UserController
{
    
    public static function newUser()
    {
        global $req;
        
        $user = new User();
        $user->setName($req->params->name . 'oi')
            ->setEmail($req->params->email)
            ->setPassword($req->params->password)
            ->save();
    }
}