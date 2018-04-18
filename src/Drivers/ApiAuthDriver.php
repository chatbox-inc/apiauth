<?php
namespace Chatbox\ApiAuth\Drivers;
use Chatbox\MailToken\TokenMailService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 5:11
 */
interface ApiAuthDriver {

	public function tokenService():TokenMailService; // トークンサービス

	public function userService():UserService; // ユーザサービス

	public function guard():Guard; // 認証中ユーザの取得

	public function handle($request, $next); //Middleware としての挙動
}