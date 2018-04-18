<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class InvitationTest extends TestCase
{
	protected $baseUrl = "http://localhost/api";

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testInvitation()
    {
    	\Illuminate\Support\Facades\Mail::fake();
    	$email = str_random()."@chatbox-inc.com";

    	$scenario = new \Chatbox\ApiAuth\Tests\Helpers\Mail\InviteUnit($this);
    	$scenario->run($email);
    	$message = $scenario->getMessage($this->response);
	    $this->refreshApplication();

    	$scenario = new \Chatbox\ApiAuth\Tests\Helpers\Profile\CreateUnit($this);
    	$scenario->run($message->token,[
    		"name" => "hoge piyo",
		    "password" => "hogehoge"
	    ]);
    	$createdUser = $scenario->getUser($this->response);
	    $this->refreshApplication();

    	$scenario = new \Chatbox\ApiAuth\Tests\Helpers\Auth\LoginUnit($this);
    	$scenario->run([
    		"email" => $email,
		    "password" => "hogehoge"
	    ]);
	    $loginUser = $scenario->getUser($this->response);
    	$token = $scenario->getToken($this->response);

    	assert($createdUser->id === $loginUser->id);

	    $this->refreshApplication();
    	$scenario = new \Chatbox\ApiAuth\Tests\Helpers\Profile\MeUnit($this);
    	$scenario->run($token);
	    $fetchedUser = $scenario->getUser($this->response);

    	assert($fetchedUser->id === $loginUser->id);

    	assert(true);

    }
}
