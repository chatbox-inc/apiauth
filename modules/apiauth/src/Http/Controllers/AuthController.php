<?php
namespace Chatbox\ApiAuth\Http\Controllers;

use Chatbox\ApiAuth\Http\Controllers\ApiAuthControllerTrait;
use Chatbox\ApiAuth\Mail\ChangeEmailMailMailable;
use Chatbox\ApiAuth\Mail\PasswordResetMailMailable;
use Chatbox\ApiAuth\Mail\TokenMailService;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/07
 * Time: 22:16
 */
class AuthController
{
    use ApiAuthControllerTrait;

    protected $mail;

    public function __construct(TokenMailService $mail)
    {
        $this->mail = $mail;
    }

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
        $user = $this->userService()->findByToken($token);
        if ($user) {
            $this->userService()->redeemLoginToken($user);
            return $this->response([
            ]);
        }
        throw new \Exception(); //TODO FIXED
    }

    public function reset_pass()
    {
        $token = $this->mailtoken();
        $message = $this->mail->inquery($token);
        if ($message instanceof PasswordResetMailMailable) {
            $payload = $this->credential();
            $this->userService()->resetPass($message->user, $payload);
            return $this->response([]);
        }
        throw new \Exception(); //TODO FIXED
    }

    public function change_email()
    {
        $token = $this->mailtoken();
        $message = $this->mail->inquery($token);
        if ($message instanceof ChangeEmailMailMailable) {
            $this->userService()->changeEmail($message->user, $message->targetAddress);
            return $this->response([]);
        }
        throw new \Exception(); //TODO FIXED
    }
}
