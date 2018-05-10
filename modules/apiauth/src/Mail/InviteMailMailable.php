<?php
namespace Chatbox\ApiAuth\Mail;

use Illuminate\Mail\Mailable;

/**
 * 各種メールテンプレートの原型
 *
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 16:19
 */
class InviteMailMailable extends TokenMailMailable {

	protected $type = "invite";

	public $targetAddress;

	public function setTargetAddress($email){
		$this->targetAddress = $email;
		$this->to($email);
	}
}