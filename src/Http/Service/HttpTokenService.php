<?php
namespace Chatbox\ApiAuth\Http\Service;
use Chatbox\ApiAuth\Domains\UserServiceInterface;
use Chatbox\Token\TokenServiceInterface;
use Chatbox\Token\Token;
use Chatbox\ApiAuth\ApiAuthService;

/**
 * User: mkkn
 * Date: 2016/06/25
 * Time: 14:20
 */
class HttpTokenService
{
    /** @var  TokenServiceInterface */
    protected $token;

    /** @var UserServiceInterface  */
    protected $user;

    public function __construct(
        ApiAuthService $apiAuthService
    ){
        $this->user = $apiAuthService->user();
        $this->token = $apiAuthService->token();
    }


    public function publish(array $credential):Token
    {
        $user = $this->user->loadProfileByCredential($credential);
        return $this->token->save($user);
    }

//    public function refresh($token){
//        return $key;
//    }
//

    public function delete($token){
        $this->token->delete($token);
    }

}