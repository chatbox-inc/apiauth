<?php
namespace Chatbox\ApiAuth;
use Chatbox\ApiAuth\Http\Actions\ProfileAction;
use Chatbox\ApiAuth\Http\Actions\TokenAction;
use Chatbox\ApiAuth\Http\Controllers\Mail\MailHandler;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Manager;

/**
 * タダのコンテナとしてのみ利用
 */
trait SetupRoute{

	public function route($name,$router){

		$router->post("/token",function(){
		});

		$router->group([
			"middleware" => ""
		],function($router){
			$router->post("/register",ProfileAction::class."@register");
			$router->get("/profile",ProfileAction::class."@show");
			$router->patch("/profile",ProfileAction::class."@update");
			$router->delete("/profile",ProfileAction::class."@delete");
		});
	}

	protected function setupRoute($router){


	}
}