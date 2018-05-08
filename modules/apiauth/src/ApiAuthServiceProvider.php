<?php
namespace Chatbox\ApiAuth;

use Chatbox\ApiAuth\Concept\ApiAuthDriver;
use Chatbox\ApiAuth\Concept\UserService;
use Chatbox\ApiAuth\Drivers\Request;
use Chatbox\MailToken\TokenMailService;
use Chatbox\MailToken\TokenService;
use Illuminate\Mail\MailServiceProvider;
use Illuminate\Routing\Router;
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

		/** @var \Illuminate\Foundation\Application $app */
		$app = $this->app;

		if( str_contains($this->app->version(), 'Lumen')){
			$app->configure("mail");
			$app->register(MailServiceProvider::class);
			$app->routeMiddleware([
				"apiauth" => ApiAuthMIddleware::class
			]);
		}else{
			$router = app("router");
			$router->aliasMiddleware("apiauth",ApiAuthMIddleware::class);

		}

	    $app->singleton(ApiAuth::class);

	    foreach ( config( "apiauth.drivers" ,[
	    	"default" => []
	    ]) as $key => $config ) {
		    $this->setupByConfig($key, $config);
		}
		$request = config("apiauth.request",\Chatbox\ApiAuth\Concept\Request::class);
	    $app->singleton(Request::class, $request);

	    $token = config("apiauth.token",\MailTokenEloquent::class);
	    $app->singleton(TokenService::class, $token);
    }

    protected function setupByConfig($key, $config)
    {
        app()->extend(ApiAuth::class, function (ApiAuth $auth) use ($key,$config) {
            $auth->setDriver($key, function () use ($config) {
                $user = app($config["user"]??UserService::class);
                return new ApiAuthDriver($user);
            });
            return $auth;
        });
    }
}
