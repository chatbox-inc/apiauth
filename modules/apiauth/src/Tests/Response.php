<?php
namespace Chatbox\ApiAuth\Tests;
use Chatbox\ApiAuth\Mail\TokenMailMailable;
use Chatbox\Token\Token;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/08
 * Time: 18:23
 */

class Response {

	/**
	 * Response constructor.
	 *
	 * @param $response
	 */
	public function __construct(\Illuminate\Http\Response $response ) {
		$this->response = $response;
	}

	public function et(){
		return $this;
	}

	public function isOK():Response{
		assert($this->response->isOk());
		return $this;
	}

	public function isBadAuth():Response{
		//TODO FIXED
		assert($this->response->getStatusCode() === 500);
		return $this;
	}

	public function get($key){
		$content = $this->response->getOriginalContent();
		return array_get($content,$key);
	}

	protected function has($key):Response{
		$content = $this->response->getOriginalContent();
		assert(array_has($content,$key));
		return $this;
	}

	public function user(){
		return $this->get("user");
	}

	public function hasUser(){
		return $this->has("user");
	}

	public function message():TokenMailMailable{
		$message = $this->get("message");
		assert($message instanceof TokenMailMailable);
		return $message;
	}

	public function hasMessage(){
		return $this->has("message");
	}

	public function token(){
		return $this->get("token");
	}

	public function hasToken(){
		return $this->has("token");
	}


}