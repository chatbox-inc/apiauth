<?php
namespace Chatbox\Token;
use Illuminate\Support\ServiceProvider;

class TokenServiceProvider extends ServiceProvider {

	public function register(  ) {
		$this->app->singleton(TokenService::class,IlluminateCacheTokenService::class);
	}
}