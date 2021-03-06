<?php
namespace Chatbox\ApiAuth\Tests\Request;

use Illuminate\Auth\RequestGuard;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/08
 * Time: 18:23
 */

class Request
{
    public static $runner;

    use MailEntries;
    use UserEntries;
    use AuthEntries;

    public function run()
    {
        return call_user_func(static::$runner, $this);
    }

    public $path;

    public $method;

    public $body;

    public function __construct($path, $method, $body=[])
    {
        $this->path   = $path;
        $this->method = $method;
        $this->body   = $body;
    }
}
