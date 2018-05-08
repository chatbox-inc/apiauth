<?php
namespace Chatbox\MailToken\Mailable;

use Illuminate\Mail\Mailable;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 16:19
 */
class TokenMessageMailable extends Mailable {

	public $token;

	public $user;

	public $to;

	protected $template;

	/**
	 * TokenMessageMailable constructor.
	 *
	 * @param $user
	 * @param $to
	 */
	public function __construct($template, $to, $user=null) {
		$this->user = $user;
		$this->setTo($to);
		$this->to   = [$to];
		$this->template = $template;
	}

	/**
	 * @param mixed $token
	 */
	public function setToken( $token ) {
		$this->token = $token;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( $user ) {
		$this->user = $user;
	}

	/**
	 * @param mixed $user
	 */
	public function getUser( ) {
		return $this->user;
	}

	/**
	 * @param mixed $to
	 */
	public function setTo( $to ) {
		$this->to = $to;
	}

	/**
	 * @param mixed $to
	 */
	public function getTo( ) {
		return $this->to;
	}

	public function build()
	{
		return $this->view($this->template);
	}
}