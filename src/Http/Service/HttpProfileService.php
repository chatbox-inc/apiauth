<?php
namespace Chatbox\ApiAuth\Http\Service;
use Chatbox\ApiAuth\ApiAuthService;
use Chatbox\ApiAuth\Domains\User;

/**
 * User: mkkn
 * Date: 2016/06/25
 * Time: 14:21
 */
class HttpProfileService
{
    protected $user;

    protected $token;

    public function __construct(
        ApiAuthService $apiAuthService
    ){
        $this->user = $apiAuthService->user();
        $this->token = $apiAuthService->token();
    }


    public function register(array $user):User{
        return $this->user->registerProfile($user);
    }

    public function findByToken($token):User{
        return $this->token->load($token)->value;
    }

    public function update($token,$user):User{
        return $user;
    }

    public function delete($token):User{
        return $user;
    }

}