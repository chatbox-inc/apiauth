<?php
namespace Chatbox\ApiAuth;

use Chatbox\Token\TokenServiceInterface;
use Illuminate\Support\ServiceProvider;

use Chatbox\ApiAuth\Domains\UserServiceInterface;


/**
 * SPの役割は注入できるポイントを提供すること
 *
 */
abstract class ApiAuthServiceProvider extends ServiceProvider
{
    use RegisterRouteTrait;

    public function register()
    {
        $app = $this->app;

        if($router = $this->getRouter()){
            $this->registerAuthRoute($router);
        }

        $app->singleton("apiauth.user",function(){
            return $this->userServiceFactory();
        });
        $app->singleton("apiauth.token",function(){
            return $this->tokenServieFactory();
        });
    }

    abstract function getRouter();

    abstract function userServiceFactory():UserServiceInterface;

    abstract function tokenServieFactory():TokenServiceInterface;
}