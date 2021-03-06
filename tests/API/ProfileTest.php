<?php
namespace Tests\API;

use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\ApiAuth\Tests\Request\LumenTestTrait;
use Chatbox\ApiAuth\Tests\Request\Request;
use Chatbox\ApiAuth\Tests\Response;
use Chatbox\ApiAuth\Tests\Scenario\ProfileScenario;
use TestCase;

class ProfileTest extends TestCase
{
	use LumenTestTrait;
	use ProfileScenario;

	protected $baseUrl = "http://localhost/api";

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test登録のチェック()
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
	    return $token;


    }

	/**
	 * @param $token
	 * @depends test登録のチェック
	 */
    public function test更新系のテスト($token){
    	$this->login($token);
	    $userUpdated = [
		    "name" => "piyopiyo",
	    ];
	    $this->scenarioUpdateUser($userUpdated);
	    Request::profile()->run();
	    $userFetched = $this->response()->isOK()->et()->user();
	    assert($userUpdated["name"] === $userFetched["name"]);
	    $this->assertTrue(true);
    }

	/**
	 * @param $token
	 * @depends test登録のチェック
	 */
    public function test削除系のテスト($token){
    	$this->login($token);
	    $this->scenarioDeleteUser();
	    $this->assertTrue(true);
    }
}
