<?php
namespace Chatbox\ApiAuth\Concept;

use Chatbox\ApiAuth\Drivers\UserService;
use Chatbox\MailToken\TokenMailService;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
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

    /**
     * ApiAuthDriver constructor.
     *
     * @param $token
     * @param $user
     * @param $guard
     */
    public function __construct(
        TokenMailService $token,
        UserService $user
    ) {
        $this->token = $token;
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
        return $next($request);
    }

    public function tokenService(): TokenMailService
    {
        return $this->token;
    }

    public function userService(): UserService
    {
        return $this->user;
    }

    public function guard():Guard
    {
        return Auth::guard();
    }

    public function handleResponse(Response $response): Response
    {
        return $response;
    }

    public function handleException(\Exception $e): \Exception
    {
        return $e;
    }
}
