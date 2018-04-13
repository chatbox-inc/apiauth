<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/13
 * Time: 3:37
 */

namespace Chatbox\ApiAuth\Concept;


use App\User;

class UserService extends User implements \Chatbox\ApiAuth\Drivers\UserService {

	public function findByEmail( string $email ) {
		// TODO: Implement findByEmail() method.
	}

	public function findByCredential( $payload ) {
		// TODO: Implement findByCredential() method.
	}

	public function create( $email, $payload ) {
		// TODO: Implement create() method.
	}

	public function resetPass( $user, $payload ) {
		// TODO: Implement resetPass() method.
	}

	public function changeEmail( $user, $payload ) {
		// TODO: Implement changeEmail() method.
	}

	public function publishLoginToken( $user ) {
		// TODO: Implement publishLoginToken() method.
	}

	public function redeemLoginToken( $token ) {
		// TODO: Implement redeemLoginToken() method.
	}


}