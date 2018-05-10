<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/18
 * Time: 18:09
 */

namespace Chatbox\ApiAuth\Concept;

class Request implements \Chatbox\ApiAuth\Drivers\Request
{
    protected $request;

    /**
     * Request constructor.
     *
     * @param $request
     */
    public function __construct(\Illuminate\Http\Request $request)
    {
        $this->request = $request;
    }


    public function credential(): array
    {
        return $this->request->get("credential", []);
    }

    public function token(): string
    {
        return $this->request->header("Authentication", "");
    }

    public function mailtoken(): string
    {
        return $this->request->get("mail_token", "");
    }

    public function email(): string
    {
        return $this->request->get("email", "");
    }

    public function user(): array
    {
        return $this->request->get("user", []);
    }
}
