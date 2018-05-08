<?php
namespace Chatbox\MailToken\Drivers;
use Chatbox\MailToken\Mailable\TokenMessageMailable;
use Chatbox\MailToken\TokenMailDriver;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/13
 * Time: 3:15
 */
class InviteMailDriver extends TokenMailDriver {

	protected $type = "invite";

	protected $templates = "mail.apiauth.invite";
}