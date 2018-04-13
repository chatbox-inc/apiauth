<?php
namespace Chatbox\ApiAuth\Drivers;
use Chatbox\MailToken\TokenMailService;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 5:11
 */
interface UserService {

	/**
	 * Email でユーザを検索
	 * @return mixed | null
	 */
	public function findByEmail(string $email);

	/**
	 * Credential でユーザを検索
	 * @return mixed | null
	 */
	public function findByCredential($payload);

	/**
	 * @param $email
	 * @param $data
	 *
	 * @return mixed
	 */
	public function create($email,$payload);

	/**
	 * @param $email
	 * @param $data
	 *
	 * @return mixed
	 */
	public function update($user,$payload);

	/**
	 * @return mixed
	 */
	public function delete($user);

	/**
	 * @param $user
	 *
	 * @return mixed
	 */
	public function resetPass($user,$payload);

	/**
	 * @param $user
	 *
	 * @return mixed
	 */
	public function changeEmail($user,$payload);

	/**
	 * @param $user
	 *
	 * @return mixed
	 */
	public function publishLoginToken($user);

	/**
	 * @param $user
	 *
	 * @return mixed
	 */
	public function redeemLoginToken($token);


}