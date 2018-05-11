<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/08
 * Time: 18:48
 */

namespace Chatbox\ApiAuth\Tests\Request;


trait MailEntries {

	static public function send_invite($email):Request{
		return new static("/mail/invite","POST",[
			"email" => $email
		]);
	}

	static public function inquery_invite($token):Request{
		return new static("/mail/invite?mail_token=$token","GET",[
		]);
	}

	static public function send_change_email($email):Request{
		return new static("/mail/change_email","POST",[
			"email" => $email
		]);
	}

	static public function inquery_change_email($token):Request{
		return new static("/mail/change_email?mail_token=$token","GET");
	}

	static public function send_reset_pass($email=null):Request{
		$params = $email ? ["email" => $email] : [];
		return new static("/mail/reset_pass","POST",$params);
	}

	static public function inquery_reset_pass($token):Request{
		return new static("/mail/reset_pass?mail_token=$token","GET");
	}

}