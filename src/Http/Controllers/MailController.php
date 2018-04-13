<?php
namespace Chatbox\ApiAuth\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/07
 * Time: 22:16
 */
class MailController {

	use ApiAuthControllerTrait;

	protected function email(){
		return $this->request()->email();
	}

	public function invite() {
		$email = $this->email();
		$user = $this->userService()->findByEmail($email);
		if(!$user){
			$message = $this->tokenService()->invite()->sendMail($email);
			return $this->response([
				"message" => $message
			]);
		}else{
			return $this->response([]);
		}
	}

	public function resetPass() {
		$email = $this->email();
		$user = $this->userService()->findByEmail($email);
		if($user){
			$message = $this->tokenService()->resetPass()->sendMail($email,$user);
			return $this->response([
				"message" => $message
			]);
		}else{
			return $this->response([]);
		}
	}

	public function changeEmail() {
		$email = $this->email();
		$user = $this->authenUser();
		$message = $this->tokenService()->changeEmail()->sendMail($email,$user);
		return $this->response([
			"message" => $message
		]);
	}

}