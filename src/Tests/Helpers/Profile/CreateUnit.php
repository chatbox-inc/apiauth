<?php
namespace Chatbox\ApiAuth\Tests\Helpers\Profile;
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
class CreateUnit {

	protected $test;

	public function __construct(TestCase $test) {
		$this->test = $test;
	}

	public function run($token,$user){
		$test = $this->send($token,$user);
		$this->assertResponseOk();
	}


	//	protected $entry;
	public function send($token,$users){
		$test = $this->test->post("/profile",[
			"mailtoken" => $token,
			"user" => $users
		]);
	}

	public function assertResponseOk(){
		$this->test->assertResponseOk();
		$this->test->seeJsonStructure([
			"user" => [],
		]);
	}

	public function getUser(Response $response){
		return $response->getOriginalContent()->data["user"];
	}
}