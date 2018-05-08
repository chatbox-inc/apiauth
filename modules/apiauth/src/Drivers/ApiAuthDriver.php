<?php
namespace Chatbox\ApiAuth\Drivers;

use Chatbox\ApiAuth\Mail\TokenMailService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailable;

/**
 * 各APIグループの依存関連はここに集約する
 * User: mkkn
 * Date: 2018/04/08
 * Time: 5:11
 */
interface ApiAuthDriver
{
    public function userService():UserService; // ユーザサービス

    public function guard():Guard; // 認証中ユーザの取得

    public function handle($request, $next); //Middleware としての挙動

    public function request():Request;

	public function message($type):Mailable;
}
