<?php
namespace Chatbox\ApiAuth\Drivers;
use Chatbox\MailToken\TokenMailService;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 5:11
 */
interface Request {

	public function credential():array;

	public function token():string;

	public function mailtoken():string;

	public function email():string;

	public function user():array;
}