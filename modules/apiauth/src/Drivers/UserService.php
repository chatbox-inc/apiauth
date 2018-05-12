<?php
namespace Chatbox\ApiAuth\Drivers;

use Chatbox\MailToken\TokenMailService;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 5:11
 */
interface UserService
{

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
     * Token でユーザを検索
     * @return mixed | null
     */
    public function findByToken($token);

    /**
     * @return mixed
     */
    public function createUser($email, $payload);

    /**
     * @return mixed
     */
    public function updateUser($user, $payload);

    /**
     * @return mixed
     */
    public function deleteUser($user):void;

    /**
     * @return mixed
     */
    public function resetPass($user, $payload);

    /**
     * @return mixed
     */
    public function changeEmail($user, $email);

    /**
     * @return mixed
     */
    public function publishLoginToken($user);

    /**
     * @return mixed
     */
    public function redeemLoginToken($user):void;
}
