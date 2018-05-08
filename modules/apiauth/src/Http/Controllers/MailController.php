<?php
namespace Chatbox\ApiAuth\Http\Controllers;

use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\MailToken\Drivers\ChangeEmailMailDriver;
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
	public function __construct(TokenMailService $mail ) {
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
	    if($message->isTypeOf($type)){
		    return $this->response([
			    "message" => $message
		    ]);
	    }else{
		    abort(404);
	    }
    }

    public function send($type)
    {
	    $type = ucfirst(strtolower($type));
	    if(is_callable([$this,"send{$type}"])){
		    return $this->{"send{$type}"}();
	    }else{
		    return abort(404);
	    }
    }

    protected function sendInvite()
    {
    	$email = $this->email();
        $user = $this->userService()->findByEmail($email);
        if (!$user) {
            $message = $this->message("invite");
            $message = $this->mail->send($message);
            return $this->response([
                "message" => $message
            ]);
        } else {
            return abort(403);
        }
    }

    protected function sendChange_email()
    {
	    $email = $this->email();
        $user = $this->userService()->findByEmail($email);
        if ($user) {
            $message = $this->driver("reset_pass")->sendMail($email, $user);
            return $this->response([
                "message" => $message
            ]);
        } else {
            return abort(403);
        }
    }
}
