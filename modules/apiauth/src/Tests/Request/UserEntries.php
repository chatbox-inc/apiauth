<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/08
 * Time: 18:48
 */

namespace Chatbox\ApiAuth\Tests\Request;


trait UserEntries {

	static public function profile():Request{
		return new static("/profile","GET");
	}

	static public function profile_register($user,$token):Request{
		return new static("/profile","POST",[
			"user" => $user,
			"mail_token" => $token
		]);
	}

	static public function profile_update($user):Request{
		return new static("/profile","PATCH",[
			"user" => $user
		]);
	}

	static public function profile_delete():Request{
		return new static("/profile","DELETE");
	}
}