<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 20:44
 */

namespace Chatbox\ApiAuth\Mail;


use Chatbox\MailToken\Mailable\TokenMessageMailable;
use Chatbox\Token\Token;
use Chatbox\Token\TokenService;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Mailer as IlluminateMailer;
use Chatbox\Token\Mail\TokenMailService as BaseTokenMailService;

/**
 * Chatbox\Token\Mail\TokenMailService を専有して、
 * Token周り、メール送信周りを担当する。
 *
 * メールの送信とトークンの照会が主な責務。
 *
 * メッセージは設定のコンテナで外から与えられる存在
 * ファクトリをここに持たない。
 *
 * ステートレス && Zero Config で
 * クラス内に設定を差し込む余地は与えない。
 *
 * @package Chatbox\ApiAuth\Mail
 */
class TokenMailService {

	/**
	 * TokenMailConfiguration constructor.
	 *
	 * @param $token
	 */
	public function __construct(BaseTokenMailService $tokenMail) {
		$this->tokenService = $tokenMail;
	}

	public function inquery(string $token):TokenMailMailable{
		$token = $this->tokenService->inquery($token);
		if($token->data instanceof TokenMailMailable){
			return $token->data;
		}
		throw new \RuntimeException("invalid token data for $token");
	}

	public function redeem($token):TokenMailMailable{
		$token = $this->tokenService->redeem(new Token($token));
		if($token->data instanceof TokenMailMailable){
			return $token->data;
		}
		throw new \RuntimeException("invalid token data for $token");
	}

	public function send(TokenMailMailable $message):TokenMailMailable{
		$token = $this->tokenService->send($message,$message->token());
		if($token->data instanceof TokenMailMailable){
			return $token->data;
		}
		throw new \RuntimeException("invalid token data for $token");
	}

}