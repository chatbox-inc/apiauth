<?php
namespace Chatbox\ApiAuth\Concept;
use Chatbox\ApiAuth\Drivers\UserService;
use Chatbox\MailToken\TokenMailService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/12
 * Time: 19:57
 */
class ApiAuthDriver implements \Chatbox\ApiAuth\Drivers\ApiAuthDriver {

	protected $token;

	protected $user;

	protected $guard;

	/**
	 * ApiAuthDriver constructor.
	 *
	 * @param $token
	 * @param $user
	 * @param $guard
	 */
	public function __construct(
		TokenMailService $token,
		UserService $user
	) {
		$this->token = $token;
		$this->user  = $user;
	}

	public function setGuard($guard){
		$this->guard = $guard;
	}


	public function tokenService(): TokenMailService {
		return $this->token;
	}

	public function userService(): UserService {
		return $this->user;
	}

	public function guard():Guard {
		return Auth::guard($this->guard);
	}

	public function handleResponse( Response $response ): Response {
		return $response;
	}

	public function handleException( \Exception $e ): \Exception {
		return $e;
	}


}