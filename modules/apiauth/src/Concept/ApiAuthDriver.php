<?php
namespace Chatbox\ApiAuth\Concept;

use Chatbox\ApiAuth\Drivers\Request;
use Chatbox\ApiAuth\Drivers\UserService;
use Chatbox\ApiAuth\Mail\ChangeEmailMailMailable;
use Chatbox\ApiAuth\Mail\InviteMailMailable;
use Chatbox\ApiAuth\Mail\PasswordResetMailMailable;
use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\ApiAuth\Mail\TokenMailService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/12
 * Time: 19:57
 */
class ApiAuthDriver implements \Chatbox\ApiAuth\Drivers\ApiAuthDriver
{
    protected $token;

    protected $user;

    protected $guard;

    protected $mailConfig = [
        "invite" => "mail.invite",
        "reset_pass" => "mail.reset_pass",
        "change_email" => "mail.change_email",
    ];

    /**
     * ApiAuthDriver constructor.
     *
     * @param $token
     * @param $user
     * @param $guard
     */
    public function __construct(
        UserService $user,
        TokenMailService $token_mail_service
    ) {
        $this->user  = $user;
        app('auth')->viaRequest('api', function ($request) use ($user) {
            if ($token = $request->bearerToken()) {
                return $user->findByToken($token);
            }
        });
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $next
     *
     * @return mixed
     */
    public function handle($request, $next)
    {
        $res = $next($request);
        return $res;
    }

    public function request(): Request
    {
        return app(\Chatbox\ApiAuth\Concept\Request::class);
    }

    public function userService(): UserService
    {
        return $this->user;
    }

    public function guard():Guard
    {
        return Auth::guard();
    }

    public function message($type):TokenMailMailable
    {
        $config = array_get($this->mailConfig, $type);
        if ($config instanceof TokenMailMailable) {
            return $config;
        } elseif ($type === "invite" && is_string($config)) {
            return new InviteMailMailable($config);
        } elseif ($type === "reset_pass" && is_string($config)) {
            return new PasswordResetMailMailable($config);
        } elseif ($type === "change_email" && is_string($config)) {
            return new ChangeEmailMailMailable($config);
        }
        throw new \Exception("invalid type");
    }
}
