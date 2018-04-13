<?php
namespace Chatbox\ApiAuth;
use Chatbox\ApiAuth\Drivers\ApiAuthDriver;
use Chatbox\ApiAuth\Http\Middlewares\ApiAuthMIddleware;

/**
 * タダのコンテナとしてのみ利用
 */
class ApiAuth{

	use SetupRoute;

	protected $active = null;

	/**
	 * @param string $active
	 */
	public function setActive(string $active ):ApiAuthDriver {
		$this->active = $active;
		return $this->active();
	}

	public function active(): ApiAuthDriver{
		return $this->driver($this->active);
	}

	public function setDriver($name,$factory){
		app()->singleton("apiauth.drivers.{$name}",$factory);
	}

	public function driver($name):ApiAuthDriver {
		$driver = app("apiauth.drivers.{$name}");
		return $driver;
	}
}