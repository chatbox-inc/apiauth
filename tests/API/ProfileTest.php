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
    public function testRegister()
    {
    	$credential = [
    		"email" => str_random()."@chatbox-inc.com",
		    "password" => str_random()
	    ];
    	$user = [
    		"name" => "hogehoge",
		    "password" => $credential["password"]
	    ];
    	$this->scenarioRegisterAndLogin($credential["email"],$user,$credential);

	    Request::profile()->run();
	    $userFetched = $this->response()->isOK()->et()->user();
	    assert($user["name"] === $userFetched["name"]);

	    $userUpdated = [
		    "name" => "piyopiyo",
		    "password" => $credential["password"]
	    ];
	    $this->scenarioUpdateUser($userUpdated);
	    Request::profile()->run();
	    $userFetched = $this->response()->isOK()->et()->user();
	    assert($userUpdated["name"] === $userFetched["name"]);

	    $this->scenarioDeleteUser();

	    $this->assertTrue(true);
    }
}
