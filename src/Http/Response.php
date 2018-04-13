<?php
namespace Chatbox\ApiAuth\Http;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 19:28
 */
class Response implements \JsonSerializable {


	protected $data;

	protected $status;

	/**
	 * ResponseBody constructor.
	 *
	 * @param $data
	 */
	public function __construct(array $data,int $status) {
		$this->data = $data;
		$this->status = $status;
	}


	public function parseMessage(){

	}

	function jsonSerialize() {
		$data = $this->data;

		$data["status"] = $this->status;
		return $data;

	}


}