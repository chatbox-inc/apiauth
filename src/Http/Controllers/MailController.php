<?php
namespace Chatbox\ApiAuth\Http\Controllers;
use Chatbox\MailToken\TokenMailDriver;

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

	protected function mailtoken(){
		return $this->request()->mailtoken();
	}

	protected function getDriver($type):TokenMailDriver{
		if($type === "invite"){
			return $this->tokenService()->invite();
		}else if($type === "reset_pass"){
			return $this->tokenService()->resetPass();
		}else if($type === "change_email"){
			return $this->tokenService()->changeEmail();
		}
		return abort(404);
	}

	public function inquery($type){
		$token = $this->mailtoken();
		$message = $this->getDriver($type)->inquery($token);
		return $this->response([
			"message" => $message
		]);
	}

	public function send($type){
		$email = $this->email();
		$driver = $this->getDriver($type);
		if($type === "invite"){
			return $this->handleSendInvitation($email,$driver);
		}else if($type === "reset_pass"){
			return $this->handleSendResetPass($email,$driver);
		}else if($type === "change_email"){
			return $this->handleSendChangeEmail($email,$driver);
		}
		return abort(404);
	}

	protected function handleSendInvitation($email,TokenMailDriver $driver){
		$user = $this->userService()->findByEmail($email);
		if(!$user){
			$message = $driver->sendMail($email);
			return $this->response([
				"message" => $message
			]);
		}else{
			return abort(403);
		}
	}

	protected function handleSendResetPass($email,TokenMailDriver $driver){
		$user = $this->userService()->findByEmail($email);
		if($user){
			$message = $driver->sendMail($email,$user);
			return $this->response([
				"message" => $message
			]);
		}else{
			return abort(403);
		}
	}

	protected function handleSendChangeEmail($email,TokenMailDriver $driver){
		$authenUser = $this->authenUser();
		$user = $this->userService()->findByEmail($email);
		if(!$user){
			$message = $driver->sendMail($email,$authenUser);
			return $this->response([
				"message" => $message
			]);
		}else{
			return abort(403);
		}
	}
}