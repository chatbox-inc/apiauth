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
use Chatbox\ApiAuth\Http\Response;
use Chatbox\MailToken\TokenMailService;
use Illuminate\Contracts\Auth\Authenticatable;
use Chatbox\ApiAuth\Drivers\Request;

trait ApiAuthControllerTrait
{
    protected function request():Request
    {
        return app(Request::class);
    }

    protected function apiauth():ApiAuthDriver
    {
        /** @var ApiAuth $apiAuth */
        $apiAuth = app(ApiAuth::class);
        return $apiAuth->active();
    }

    protected function tokenService():TokenMailService
    {
        return $this->apiauth()->tokenService();
    }

    protected function userService():UserService
    {
        return $this->apiauth()->userService();
    }

    protected function authenUser():Authenticatable
    {
        // TODO FIXED
        return $this->apiauth()->guard()->user();

        throw new \Exception("非認証時にはそれなりのエラーを投げる");
    }

    protected function response($data, $status = 200):Response
    {
        return new Response($data, $status);
    }
}
