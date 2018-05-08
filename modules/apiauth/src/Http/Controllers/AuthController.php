<?php
namespace Chatbox\ApiAuth\Http\Controllers;

use Chatbox\ApiAuth\Http\Controllers\ApiAuthControllerTrait;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/07
 * Time: 22:16
 */
class AuthController
{
    use ApiAuthControllerTrait;

    protected function credential()
    {
        return $this->request()->credential();
    }

    protected function token()
    {
        return $this->request()->token();
    }

    protected function mailtoken()
    {
        return $this->request()->mailtoken();
    }

    public function login()
    {
        $payload = $this->credential();
        $user = $this->userService()->findByCredential($payload);
        if ($user) {
            $token = $this->userService()->publishLoginToken($user);
            return $this->response([
                "user" => $user,
                "token" => $token
            ]);
        }
        throw new \Exception(); //TODO FIXED
    }

    public function logout()
    {
        $token = $this->token();
        $this->userService()->redeemLoginToken($token);
        return $this->response([]);
    }

    public function reset_pass()
    {
        $token = $this->mailtoken();
        $message = $this->apiauth()->mailHandler("reset_pass")->inquery($token);
        if ($message) {
            $payload = $this->credential();
            $this->userService()->resetPass($message->getUser(), $payload);
            return $this->response([]);
        }
        throw new \Exception(); //TODO FIXED
    }

    public function change_email()
    {
        $token = $this->mailtoken();
        $message = $this->apiauth()->mailHandler("change_email")->inquery($token);
        if ($message) {
            $this->userService()->changeEmail($message->getUser(), $message->getTo());
            return $this->response([]);
        }
        throw new \Exception(); //TODO FIXED
    }
}
