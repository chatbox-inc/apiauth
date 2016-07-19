<?php
namespace Chatbox\ApiAuth\Http\Controllers;
use Chatbox\ApiAuth\Http\AuthRequest;
use Chatbox\ApiAuth\Http\Service\HttpTokenService;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/06/17
 * Time: 14:42
 */
class TokenController
{
    protected $request;
    protected $service;

    /**
     * TokenController constructor.
     * @param $request
     * @param $service
     */
    public function __construct(
        AuthRequest $request,
        HttpTokenService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }


    public function login()
    {
        $cred = $this->request->getCredential();
        $key = $this->service->publish($cred);
        return [
            "token" => $key,
        ];
    }

//    public function refresh(){
//        $token = $this->request->getToken();
//        $token = $this->service->refresh($token);
//        return [
//            "token" => $token,
//        ];
//    }


    public function logout()
    {
        $token = $this->request->getToken();
        $this->service->delete($token);
        return [];
    }

}