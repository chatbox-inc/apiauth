<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/07/19
 * Time: 15:47
 */

namespace Chatbox\ApiAuth;


use Chatbox\ApiAuth\Domains\UserServiceInterface;
use Chatbox\Token\TokenServiceInterface;

/**
 * 依存コンポーネントを一括管理する
 * Http周りまで面倒を見るわけではない。
 * (HttpではHttp向けに再構築がとられる)
 *
 * Class ApiAuthService
 * @package Chatbox\ApiAuth
 */
class ApiAuthService
{
    protected $user;

    protected $token;

    /**
     * ApiAuthService constructor.
     * @param $user
     * @param $token
     */
    public function __construct(UserServiceInterface $user,TokenServiceInterface $token)
    {
        $this->user = $user;
        $this->token = $token;
    }


    public function user():UserServiceInterface{
        return $this->user;
    }

    public function token():TokenServiceInterface{
        return $this->token;
    }
}