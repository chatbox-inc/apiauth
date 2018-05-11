<?php
namespace Tests\API;

use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\ApiAuth\Tests\Request\LumenTestTrait;
use Chatbox\ApiAuth\Tests\Request\Request;
use Chatbox\ApiAuth\Tests\Response;
use TestCase;

class InvitationTest extends TestCase
{
	use LumenTestTrait;
	protected $baseUrl = "http://localhost/api";

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvitation()
    {
    	$email = str_random()."@chatbox-inc.com";
    	Request::send_invite($email)->run();

    	$message = $this->response()->get("message");

		$this->response()->isOK();
		$message = $this->response()->get("message");
		assert($message instanceof TokenMailMailable);

    	Request::inquery_invite($message->token())->run();
	    $message = $this->response()->isOK();
	    $message = $this->response()->get("message");
	    assert($message instanceof TokenMailMailable);

	    $this->assertTrue(true);
    }
}
