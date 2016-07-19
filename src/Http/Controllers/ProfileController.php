<?php
namespace Chatbox\ApiAuth\Http\Controllers;
use Chatbox\ApiAuth\Http\AuthRequest;
use Chatbox\ApiAuth\Http\Service\HttpProfileService;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/06/17
 * Time: 14:42
 */
class ProfileController
{

    protected $request;

    protected $service;

    /**
     * ProfileController constructor.
     * @param $request
     * @param $service
     */
    public function __construct(
        AuthRequest $request,
        HttpProfileService $service)
    {
        $this->request = $request;
        $this->service = $service;
    }

    public function create()
    {
        $user = $this->request->getUserDataForRegister();
        $user = $this->service->register($user);
        return [
            "user" => $user
        ];
    }

    public function load(){
        $token = $this->request->getToken();
        $user = $this->service->findByToken($token);
        return [
            "user" => $user
        ];
    }

    public function update(){
        $token = $this->request->getToken();
        $user = $this->request->getUserDataForUpdate();
        $user = $this->service->update($token,$user);
        return [
            "user" => $user
        ];
    }

    public function ban(){
        $token = $this->request->getToken();
        $user = $this->service->delete($token);
        return [
            "user" => $user
        ];
    }


}