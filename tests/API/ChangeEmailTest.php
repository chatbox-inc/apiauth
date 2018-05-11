<?php
namespace Tests\API;

use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\ApiAuth\Tests\Request\LumenTestTrait;
use Chatbox\ApiAuth\Tests\Request\Request;
use Chatbox\ApiAuth\Tests\Response;
use Chatbox\ApiAuth\Tests\Scenario\ChangeEmailScenario;
use Chatbox\ApiAuth\Tests\Scenario\PasswordResetScenario;
use Chatbox\ApiAuth\Tests\Scenario\ProfileScenario;
use Illuminate\Support\Str;
use TestCase;

class ChangeEmailTest extends TestCase
{
	use LumenTestTrait;
	use ProfileScenario;
	use ChangeEmailScenario;

	protected $baseUrl = "http://localhost/api";

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test登録を実施しトークンを作成()
    {
    	$credential = [
    		"email" => str_random()."@chatbox-inc.com",
		    "password" => str_random()
	    ];
    	$user = [
    		"name" => "hogehoge",
		    "password" => $credential["password"]
	    ];

    	$token = $this->scenarioRegisterAndLogin($credential["email"],$user,$credential);

	    Request::profile()->run();
	    $this->response()->isOK()->et()->user();
	    $this->assertTrue(true);
	    return [
		    "credential" => $credential,
		    "token" => $token
	    ];
    }

	/**
	 * @param $token
	 * @depends test登録を実施しトークンを作成
	 */
    public function testメール変更の実施($chunk){
    	$credential = $chunk["credential"];
    	$token = $chunk["token"];
    	$this->login($token);
	    $credential["email"] = str_random()."@chatbox-inc.com";

	    $mailtoken = $this->scenarioChangeEmailMailSend($credential["email"]);

	    $this->scenarioChangeEmail($mailtoken,$credential);
	    $this->assertTrue(true);
    }
}
