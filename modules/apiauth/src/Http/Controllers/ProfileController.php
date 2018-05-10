<?php
namespace Chatbox\ApiAuth\Http\Controllers;
use Chatbox\ApiAuth\Mail\TokenMailService;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/07
 * Time: 22:16
 */
class ProfileController
{
    use ApiAuthControllerTrait;

	/**
	 * MailController constructor.
	 *
	 * @param $mail
	 */
	public function __construct(TokenMailService $mail ) {
		$this->mail = $mail;
	}

	public function me()
    {
        $user = $this->authenUser();
        return $this->response([
            "user" => $user
        ]);
    }

    public function create()
    {
        $token = $this->request()->mailtoken();

        $message = $this->mail->inquery($token);
        if ($message && $message->isTypeOf("invite")) {
            $userPayload = $this->request()->user();
            $user = $this->userService()->createUser($message->targetAddress, $userPayload);
            return $this->response([
                "user" => $user
            ]);
        } else {
            throw new \Exception(); //TODO FIXED
        }
    }

    public function update()
    {
        $user = $this->authenUser();
        $userPayload = $this->request()->user();
        $user = $this->userService()->updateUser($user, $userPayload);
        return $this->response([
            "user" => $user
        ]);
    }

    public function delete()
    {
        $user = $this->authenUser();
        $user = $this->userService()->deleteUser($user);
        return $this->response([
            "user" => $user
        ]);
    }
}
