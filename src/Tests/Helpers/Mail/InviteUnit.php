<?php
namespace Chatbox\ApiAuth\Tests\Helpers\Mail;
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
class InviteUnit {

	protected $test;

	public function __construct(TestCase $test) {
		$this->test = $test;
	}

	public function run($email){
		$test = $this->send($email);
		$this->assertResponseOk();
		$this->assertMailSent($email);
	}


//	protected $entry;

	public function send($email,$data=[]){
		$test = $this->test->post("/mail/invite",[
			"email" => $email
		]);
	}

	public function assertMailSent($email){
		Mail::assertSent(TokenMessageMailable::class, function (TokenMessageMailable $mail) use ($email) {
			return $mail->to == $email;
		});
	}

	public function assertResponseOk(){
		$this->test->assertResponseOk();
		$this->test->seeJsonStructure([
			"message" => []
		]);
	}

	public function getMessage(Response $response):TokenMessageMailable{
		return $response->getOriginalContent()->data["message"];
	}
}