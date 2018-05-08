<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 17:27
 */

namespace Chatbox\MailToken;

use Chatbox\MailToken\Drivers\ChangeEmailMailDriver;
use Chatbox\MailToken\Drivers\InviteMailDriver;
use Chatbox\MailToken\Drivers\ResetPassMailDriver;

class TokenMailService {

	protected $invite;

	protected $changeMail;

	protected $resetPass;

	/**
	 * TokenMailService constructor.
	 *
	 * @param $invite
	 * @param $changeMail
	 * @param $resetPass
	 */
	public function __construct(InviteMailDriver $invite,ChangeEmailMailDriver $changeMail,ResetPassMailDriver $resetPass ) {
		$this->invite     = $invite;
		$this->changeMail = $changeMail;
		$this->resetPass  = $resetPass;
	}

	public function invite():TokenMailDriver{
		return $this->invite;
	}

	public function resetPass():TokenMailDriver{
		return $this->resetPass;
	}

	public function changeEmail():TokenMailDriver{
		return $this->changeMail;
	}
}