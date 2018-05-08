<?php
namespace Chatbox\ApiAuth\Tests\Helpers\Auth;

use Chatbox\MailToken\Mailable\TokenMessageMailable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Testing\TestCase;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/18
 * Time: 16:05
 */
class LoginUnit
{
    protected $test;

    public function __construct(TestCase $test)
    {
        $this->test = $test;
    }

    public function run($credential)
    {
        $test = $this->send($credential);
        $this->assertResponseOk();
    }


    //	protected $entry;

    public function send($credential)
    {
        $test = $this->test->post("/auth/login", [
            "credential" => $credential
        ]);
    }

    public function assertResponseOk()
    {
        $this->test->assertResponseOk();
        $this->test->seeJsonStructure([
            "token" => [],
            "user" => []
        ]);
    }

    public function getUser(Response $response)
    {
        return $response->getOriginalContent()->data["user"];
    }
    public function getToken(Response $response)
    {
        return $response->getOriginalContent()->data["token"];
    }
}
