<?php
namespace Tests\API;

use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\ApiAuth\Tests\Request\LumenTestTrait;
use Chatbox\ApiAuth\Tests\Request\Request;
use Chatbox\ApiAuth\Tests\Response;
use Chatbox\ApiAuth\Tests\Scenario\PasswordResetScenario;
use Chatbox\ApiAuth\Tests\Scenario\ProfileScenario;
use Illuminate\Support\Str;
use TestCase;

class PasswordResetTest extends TestCase
{
	use LumenTestTrait;
	use ProfileScenario;
	use PasswordResetScenario;

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
	    $userFetched = $this->response()->isOK()->et()->user();
	    assert($user["name"] === $userFetched["name"]);
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
    public function testパスワードリセットの実施($chunk){
    	$token = $chunk["token"];
    	$credential = $chunk["credential"];
    	$this->login($token);
	    $token = $this->scenarioSendPasswordResetMail();

	    $credential["password"] = Str::random();

	    $this->scenarioPasswordReset($token,$credential);
	    $this->assertTrue(true);
    }

	/**
	 * @param $token
	 * @depends test登録を実施しトークンを作成
	 */
    public function testパスワードリセットの実施2($chunk){
    	$credential = $chunk["credential"];

	    $token = $this->scenarioSendPasswordResetMail($credential["email"]);
	    $credential["password"] = Str::random();
	    $this->scenarioPasswordReset($token,$credential);
	    $this->assertTrue(true);
    }

}
