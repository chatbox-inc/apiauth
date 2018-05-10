<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/09
 * Time: 19:34
 */

namespace Chatbox\ApiAuth\Tests\Scenario;

use Chatbox\ApiAuth\Tests\Request\Request;
use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\ApiAuth\Tests\Response;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

trait ProfileScenario {

	abstract protected function response():Response;

	public function scenarioRegisterAndLogin($email,$userData,$credential){
		Request::send_invite($email)->run();

		$message = $this->response()->get("message");

		$this->response()->isOK();
		$message = $this->response()->get("message");
		assert($message instanceof TokenMailMailable);

		Request::profile_register($userData,$message->token())->run();
		$this->response()->isOK();
		$user = $this->response()->get("user");
		assert($user);

		Request::login($credential)->run();
		$this->response()->isOK();
		$token = $this->response()->get("token");
		assert($token == true);

		$this->login($token);
		Request::profile()->run();
		$this->response()->isOK();
		$user2 = $this->response()->get("user");
		assert($user2);
		return $token;
	}

	public function scenarioUpdateUser($userData){
		// YOU need to login
		Request::profile()->run();
		$this->response()->isOK()->et()->hasUser();

		Request::profile_update($userData)->run();
		$this->response()->isOK()->et()->hasUser();

		return $this->response()->user();
	}

	public function scenarioDeleteUser(){
		// YOU need to login
		Request::profile()->run();
		$this->response()->isOK()->et()->hasUser();

		Request::profile_delete()->run();
		$this->response()->isOK()->et()->hasUser();

		Request::profile()->run();
		$this->response()->isBadAuth();
	}

}