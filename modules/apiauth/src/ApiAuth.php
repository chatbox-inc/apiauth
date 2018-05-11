<?php
namespace Chatbox\ApiAuth;

use Chatbox\ApiAuth\Drivers\ApiAuthDriver;
use Chatbox\ApiAuth\Http\Middlewares\ApiAuthMIddleware;
use Illuminate\Support\Manager;

/**
 * コンテナを操作するための機構
 *
 *
 */
class ApiAuth extends Manager
{
    use SetupRoute;

    protected $active = null;

    public function getDefaultDriver()
    {
        return $this->active;
    }

    public function setActive(string $active)
    {
        $this->active = $active;
    }

    public function active(): ApiAuthDriver
    {
        return $this->driver();
    }

    public function extendWithConfig($name, $config)
    {
        # now only support a config as factory
        return $this->extend($name, $config);
    }
}
