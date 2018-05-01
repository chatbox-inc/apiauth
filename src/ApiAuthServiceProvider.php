<?php
namespace Chatbox\ApiAuth;

use Chatbox\ApiAuth\Concept\ApiAuthDriver;
use Chatbox\ApiAuth\Concept\UserService;
use Chatbox\ApiAuth\Drivers\Request;
use Chatbox\MailToken\TokenMailService;
use Chatbox\MailToken\TokenService;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Support\ServiceProvider;
use Chatbox\ApiAuth\ApiAuth;
use Laravel\Lumen\Application;
use Chatbox\ApiAuth\Http\Middlewares\ApiAuthMIddleware;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/03/25
 * Time: 3:47
 */
class ApiAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->setupByConfig("default", []);

		/** @var \Illuminate\Foundation\Application $app */
		$app = $this->app;

		if( str_contains($this->app->version(), 'Lumen')){
			$app->configure("mail");
			$app->register(MailServiceProvider::class);
		}

        $app->singleton(ApiAuth::class);
        //TODO FIXED
        $app->singleton(Request::class, \Chatbox\ApiAuth\Concept\Request::class);
        $app->singleton(TokenService::class, \MailTokenEloquent::class);

        $app->routeMiddleware([
            "apiauth" => ApiAuthMIddleware::class
        ]);
    }

    protected function setupByConfig($key, $config)
    {
        app()->extend(ApiAuth::class, function (ApiAuth $auth) use ($key,$config) {
            $auth->setDriver($key, function () use ($config) {
                $token = app($config["token"]??TokenMailService::class);
                $user = app($config["user"]??UserService::class);
                return new ApiAuthDriver($token, $user);
            });
            return $auth;
        });
    }
}
