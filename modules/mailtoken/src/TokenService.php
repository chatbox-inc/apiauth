<?php
namespace Chatbox\MailToken;
use Chatbox\MailToken\Mailable\TokenMessageMailable;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 4:00
 */
interface TokenService {

	public function publish(string $email, $data,string $type = "default"):string;

	public function redeem(string $token,string $type = "default"):void;

	public function inquery(string $token,string $type = "default"): ?TokenMessageMailable;
}