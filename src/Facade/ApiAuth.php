<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/13
 * Time: 2:45
 */

namespace Chatbox\ApiAuth\Facade;

use Illuminate\Support\Facades\Facade;
use Chatbox\ApiAuth\Drivers\ApiAuthDriver;

/**
 * Class ApiAuth
 * @package Chatbox\ApiAuth\Facade
 * @method static ApiAuthDriver driver(string $name)
 * @method static void route(string $name, $router)
 */
class ApiAuth extends Facade
{
    public static function getFacadeAccessor()
    {
        return \Chatbox\ApiAuth\ApiAuth::class;
    }
}
