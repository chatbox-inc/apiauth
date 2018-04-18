<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/13
 * Time: 3:37
 */

namespace Chatbox\ApiAuth\Concept;


use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;

class UserService extends User implements \Chatbox\ApiAuth\Drivers\UserService {

	protected $table = "users";

	public function findByEmail( string $email ) {
		return $this->where("email",$email)->first();
	}

	public function findByCredential( $payload ) {
		$user = $this->findByEmail(array_get($payload,"email"));
		if($user && Hash::check(array_get($payload,"password"),$user->password)){
			return $user;
		}
		return null;
	}

	public function findByToken( $token ) {
		$user = $this->where("remember_token",$token)->first();
		return $user;
	}

	public function createUser( $email, $payload ) {
		/** @var Validator $val */
		$val = validator($payload,[
			"name" => ["required","max:250"],
			"password" => ["required"],
		]);
		if($val->passes()){
			$model = $this->newInstance();
			$model->name = array_get($payload,"name");
			$model->password = Hash::make(array_get($payload,"password"));
			$model->email = $email;
			$model->save();
			return $model;
		}else{
			throw new ValidationException($val);
		}
	}

	public function updateUser( $user, $payload ) {
		assert($user instanceof User);
		/** @var Validator $val */
		$val = validator($payload,[
			"name" => ["required","max:250"],
		]);
		if($val->passes()){
			$user->name = array_get($payload,"name");
			$user->save();
			return $user;
		}else{
			throw new ValidationException($val);
		}
	}

	public function deleteUser( $user ) {
		assert($user instanceof User);
		$user->delete();
	}

	public function resetPass( $user, $payload ) {
		assert($user instanceof User);
		/** @var Validator $val */
		$val = validator($payload,[
			"password" => ["required"],
		]);
		if($val->passes()){
			$user->password = Hash::make(array_get($payload,"password"));
			$user->save();
			return $user;
		}else{
			throw new ValidationException($val);
		}
	}

	public function changeEmail( $user, $email ) {
		assert($user instanceof User);
		$user->email = $email;
		$user->save();
		return $user;
	}

	public function publishLoginToken( $user ) {
		assert($user instanceof User);
		$token = str_random();
		$user->remember_token = $token;
		$user->save();
		return $token;
	}

	public function redeemLoginToken( $token ) {
		$user = $this->findByToken($token);
		if($user){
			$user->remember_token = null;
			$user->save();
		}
	}
}