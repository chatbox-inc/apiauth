<?php
namespace App;
use App\Model\UserTable;
use Chatbox\ApiAuth\ApiAuthServiceProvider;
use Chatbox\ApiAuth\RegisterRouteTrait;
use Chatbox\ApiAuth\Domains\UserServiceInterface;
use Chatbox\Token\Storage\Mock\ArrayStorage;
use Chatbox\Token\TokenService;
use Chatbox\Token\TokenServiceInterface;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/07/19
 * Time: 12:44
 */
class ServiceProvider extends ApiAuthServiceProvider
{
    function getRouter()
    {
        return $this->app;
    }


    function userServiceFactory():UserServiceInterface
    {
        return new UserTable();
    }

    function tokenServieFactory():TokenServiceInterface
    {
        $storage = new ArrayStorage();
        return new TokenService($storage);
    }
}