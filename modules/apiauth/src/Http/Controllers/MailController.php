<?php
namespace Chatbox\ApiAuth\Http\Controllers;

use Chatbox\ApiAuth\Mail\ChangeEmailMailMailable;
use Chatbox\ApiAuth\Mail\InviteMailMailable;
use Chatbox\ApiAuth\Mail\PasswordResetMailMailable;
use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\ApiAuth\Mail\TokenMailService;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/07
 * Time: 22:16
 */
class MailController
{
    use ApiAuthControllerTrait;

    protected $mail;

    /**
     * MailController constructor.
     *
     * @param $mail
     */
    public function __construct(TokenMailService $mail)
    {
        $this->mail = $mail;
    }

    protected function email()
    {
        return $this->request()->email();
    }

    protected function mailtoken()
    {
        return $this->request()->mailtoken();
    }

    protected function message($type):TokenMailMailable
    {
        return $this->apiauth()->message($type);
    }

    public function inquery($type)
    {
        $token = $this->mailtoken();
        $message = $this->mail->inquery($token);
        if ($message && $message->isTypeOf($type)) {
            return $this->response([
                "message" => $message
            ]);
        } else {
            abort(404);
        }
    }

    public function send($type)
    {
        $type = ucfirst(strtolower(str_replace("_", "", $type)));
        if (is_callable([$this,"send{$type}"])) {
            return $this->{"send{$type}"}();
        } else {
            abort(404);
        }
    }

    protected function sendInvite()
    {
        $email = $this->email();
        $user = $this->userService()->findByEmail($email);
        if (!$user) {
            $message = $this->message("invite");
            assert($message instanceof InviteMailMailable);
            $message->setTargetAddress($email);
            $message = $this->mail->send($message);
            return $this->response([
                "message" => $message
            ]);
        } else {
            abort(403);
        }
    }

    protected function sendResetpass()
    {
        $user = $this->apiauth()->guard()->user();
        if (! $user) {
            $email = $this->email();
            $user = $this->userService()->findByEmail($email);
        }
        if ($user) {
            $message = $this->message("reset_pass");
            assert($message instanceof PasswordResetMailMailable);
            $message->setUser($user);
            $message = $this->mail->send($message);
            return $this->response([
                "message" => $message
            ]);
        } else {
            abort(403);
        }
    }

    protected function sendChangeemail()
    {
        $email = $this->email();
        $user = $this->apiauth()->guard()->user();
        if ($user) {
            $message = $this->message("change_email");
            assert($message instanceof ChangeEmailMailMailable);
            $message->setUser($user);
            $message->setTargetAddress($email);
            $message = $this->mail->send($message);
            return $this->response([
                "message" => $message
            ]);
        } else {
            abort(403);
        }
    }
}
