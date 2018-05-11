<?php
namespace Chatbox\ApiAuth\Mail;

use Illuminate\Mail\Mailable;

/**
 * 各種メールテンプレートの原型
 *
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 16:19
 */
class ChangeEmailMailMailable extends TokenMailMailable
{
    protected $type = "change_email";

    public $user;

    public $targetAddress;

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setTargetAddress($address)
    {
        $this->targetAddress = $address;
        $this->to($address);
    }
}
