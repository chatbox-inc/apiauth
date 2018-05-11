<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/09
 * Time: 19:34
 */

namespace Chatbox\ApiAuth\Tests\Scenario;

use Chatbox\ApiAuth\Mail\PasswordResetMailMailable;
use Chatbox\ApiAuth\Tests\Request\Request;
use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\ApiAuth\Tests\Response;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

trait PasswordResetScenario {

	abstract protected function response():Response;

	public function scenarioSendPasswordResetMail($email=null){
		# メール送信
		Request::send_reset_pass($email)->run();
		$this->response()->isOK()->et()->hasMessage();
		$message = $this->response()->message();
		assert($message instanceof PasswordResetMailMailable);

		# トークンの問い合わせ
		Request::inquery_reset_pass($message->token())->run();
		$this->response()->isOK()->et()->hasMessage();
		$message = $this->response()->message();
		assert($message instanceof PasswordResetMailMailable);

		return $message->token();
	}

	public function scenarioPasswordReset($token,$credential){
		# トークンを使ってリセットを実施
		Request::auth_reset_pass($token,$credential)->run();
		$this->response()->isOK();

		# 実施したリセットパスでログイン出来ること
		Request::login($credential)->run();
		$this->response()->isOK()->et()->hasToken();
	}

}