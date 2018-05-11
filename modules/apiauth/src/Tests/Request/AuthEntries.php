<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/08
 * Time: 18:48
 */

namespace Chatbox\ApiAuth\Tests\Request;


trait AuthEntries {

	static public function login($credential):Request{
		return new static("/auth/login","POST",[
			"credential" => $credential
		]);
	}

	static public function logout():Request{
		return new static("/auth/logout","POST");
	}

	static public function auth_reset_pass($mailToken,$credential):Request{
		return new static("/auth/reset_pass","POST",[
			"mail_token" => $mailToken,
			"credential" => $credential
		]);
	}

	static public function auth_change_email($mailToken):Request{
		return new static("/auth/change_email","POST",[
			"mail_token" => $mailToken,
		]);
	}
}