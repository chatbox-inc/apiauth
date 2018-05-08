<?php
namespace Chatbox\Token;
use Carbon\Carbon;
use Chatbox\MailToken\Mailable\TokenMessageMailable;

/**
 * トークン本体
 * User: mkkn
 * Date: 2018/04/08
 * Time: 4:00
 */
class Token {

	public $token;

	public $data;

	public $createdAt;

	/**
	 * Token constructor.
	 *
	 * @param $token
	 * @param $data
	 * @param $createdAt
	 */
	public function __construct( $token, $data=[],Carbon $createdAt = null ) {
		$this->token     = $token;
		$this->data      = $data;
		$this->createdAt = $createdAt ?: Carbon::now();
	}


}