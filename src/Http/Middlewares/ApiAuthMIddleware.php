<?php
namespace Chatbox\ApiAuth\Http\Middlewares;
use Chatbox\ApiAuth\ApiAuth;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 19:25
 */
class ApiAuthMIddleware {

	protected $apiauth;

	/**
	 * ApiAuthMIddleware constructor.
	 *
	 * @param $apiauth
	 */
	public function __construct(ApiAuth $apiauth ) {
		$this->apiauth = $apiauth;
	}

	public function handle( $request, $next,$type ) {

		$auth = $this->apiauth->setActive($type);
		try{
			$response = $next($request);
			return $auth->handleResponse($response);
		}catch (Exception $e){
			throw $auth->handleException($e);
		}
	}

}