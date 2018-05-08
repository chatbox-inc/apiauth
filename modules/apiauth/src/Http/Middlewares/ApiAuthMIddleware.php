<?php
namespace Chatbox\ApiAuth\Http\Middlewares;

use Chatbox\ApiAuth\ApiAuth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 19:25
 */
class ApiAuthMIddleware
{
    protected $apiauth;

    /**
     * ApiAuthMIddleware constructor.
     *
     * @param $apiauth
     */
    public function __construct(ApiAuth $apiauth)
    {
        $this->apiauth = $apiauth;
    }

    public function handle($request, $next, $type="default")
    {
        $this->apiauth->setActive($type);
        $auth = $this->apiauth->active();
        try {
        	return $auth->handle($request, $next);
        }catch (\Exception $e){
        	dd($e);
        	$response = Response::create([
        		"errors" => $e->getMessage(),
	        ],500);
        	throw new HttpResponseException($response);
        }
    }
}
