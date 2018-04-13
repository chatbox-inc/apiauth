<?php
namespace Chatbox\ApiAuth;
use Chatbox\ApiAuth\Concept\ApiAuthDriver;
use Chatbox\ApiAuth\Concept\UserService;
use Chatbox\MailToken\TokenMailService;
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
class ApiAuthServiceProvider extends ServiceProvider {

	public function register(){
		$this->setupByConfig("default",[]);

		/** @var Application $app */
		$app = $this->app;

		$app->routeMiddleware("apiauth",ApiAuthMIddleware::class);
	}

	protected function setupByConfig($key,$config){
		app()->extend(ApiAuth::class,function (ApiAuth $auth)use($key,$config){
			$token = app($config["token"]??TokenMailService::class);
			$user = app($config["user"]??UserService::class);

			$auth->setDriver($key,new ApiAuthDriver($token,$user));
			return $auth;
		});
	}
}