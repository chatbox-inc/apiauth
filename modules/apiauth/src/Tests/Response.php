<?php
namespace Chatbox\ApiAuth\Tests;
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

	public function isOK(){
		assert($this->response->isOk());
	}

	public function get($key){
		$content = $this->response->getOriginalContent();
		return array_get($content,$key);
	}


}