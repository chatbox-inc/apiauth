<?php
namespace Chatbox\ApiAuth\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/07
 * Time: 22:16
 */
class ProfileController {

	use ApiAuthControllerTrait;

	public function get( ) {
		$user = $this->authenUser();
		return $this->response([
			"user" => $user
		]);
	}

	public function create( ) {
		$token = $this->request()->token();

		$message = $this->tokenService()->invite()->inquery($token);
		if($message){
			$userPayload = $this->request()->user();
			$user = $this->userService()->create($message->getTo(),$userPayload);
			return $this->response([
				"user" => $user
			]);
		}else{
			throw new \Exception(); //TODO FIXED
		}
	}

	public function update( ) {
		$user = $this->authenUser();
		$userPayload = $this->request()->user();
		$user = $this->userService()->update($user,$userPayload);
		return $this->response([
			"user" => $user
		]);
	}

	public function delete( ) {
		$user = $this->authenUser();
		$user = $this->userService()->delete($user);
		return $this->response([
			"user" => $user
		]);
	}
}