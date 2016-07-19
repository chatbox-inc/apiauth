<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/07/19
 * Time: 15:47
 */

namespace Chatbox\ApiAuth;


use Chatbox\ApiAuth\Domains\UserServiceInterface;
use Chatbox\Token\TokenServiceInterface;

class ApiAuthService
{
    public function user():UserServiceInterface{
        return app("apiauth.user");
    }

    public function token():TokenServiceInterface{
        return app("apiauth.token");
    }
}