<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 20:44
 */

namespace Chatbox\MailToken;


use Chatbox\MailToken\Mailable\TokenMessageMailable;
use Chatbox\MailToken\TokenService;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Mailer as IlluminateMailer;

abstract class TokenMailDriver {

	protected $type = "default";

	protected $shouldQueue = false;

	protected $templates = "mail.default";

	protected $tokenService;

	protected $mailer;

	/**
	 * TokenMailConfiguration constructor.
	 *
	 * @param $token
	 */
	public function __construct(TokenService $token) {
		$this->tokenService = $token;
		$this->mailer = app("mailer");
	}

	public function inquery($token):TokenMessageMailable{
		$message = $this->tokenService->inquery($token,$this->type);
		return $message;
	}

	public function sendMail($toAddress,$user=null){
		$message = $this->message($toAddress,$user);
		$token = $this->tokenService->publish($toAddress,$message,$this->type);
		$message->setToken($token);

		$mailer = $this->handleMailer($this->mailer);
		if($this->shouldQueue && $mailer instanceof IlluminateMailer){
			$mailer->queue($message);
		}else{
			$mailer->send($message);
		}
		return $message;
	}

	protected function message( $toAddress, $user = null ): TokenMessageMailable {
		return new TokenMessageMailable($this->templates,$toAddress,$user);
	}

	protected function handleMailer($mail):Mailer{
		return $mail;
	}
}