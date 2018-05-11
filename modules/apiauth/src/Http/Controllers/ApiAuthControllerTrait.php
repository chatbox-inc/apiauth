<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 17:56
 */

namespace Chatbox\ApiAuth\Http\Controllers;

use Chatbox\ApiAuth\ApiAuth;
use Chatbox\ApiAuth\Drivers\ApiAuthDriver;
use Chatbox\ApiAuth\Drivers\UserService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Chatbox\ApiAuth\Drivers\Request;

trait ApiAuthControllerTrait
{
    protected function request():Request
    {
        return $this->apiauth()->request();
    }

    protected function apiauth():ApiAuthDriver
    {
        /** @var ApiAuth $apiAuth */
        $apiAuth = app(ApiAuth::class);
        return $apiAuth->active();
    }

//    protected function tokenService():TokenMailService
//    {
//        return $this->apiauth()->tokenService();
//    }

    protected function userService():UserService
    {
        return $this->apiauth()->userService();
    }

    protected function authenUser():Authenticatable
    {
        if ($user = $this->apiauth()->guard()->user()) {
            return $user;
        }
        throw new AuthenticationException();
    }

    protected function response($data, $status = 200)
    {
        return response($data, $status);
    }
}
