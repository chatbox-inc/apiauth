<?php
namespace Chatbox\ApiAuth;

use Chatbox\ApiAuth\Concept\ApiAuthDriver;
use Chatbox\ApiAuth\Concept\UserService;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Chatbox\ApiAuth\Http\Middlewares\ApiAuthMIddleware;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/03/25
 * Time: 3:47
 */
class ApiAuthServiceProvider extends ServiceProvider
{
    public function register()
    {

        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        $router = app("router");
        $router->aliasMiddleware("apiauth", ApiAuthMIddleware::class);

        # Setup singleton
        $app->singleton(ApiAuth::class, function () {
            return new ApiAuth($this->app);
        });

        $defaultConfig = [
            "default" => function () {
                return new ApiAuthDriver(
                    app(UserService::class),
                    app(\Chatbox\ApiAuth\Mail\TokenMailService::class)
                );
            }
        ];
        foreach (config("apiauth.drivers", $defaultConfig) as $key => $config) {
            app()->extend(ApiAuth::class, function (ApiAuth $auth) use ($key,$config) {
                $auth->extendWithConfig($key, $config);
                return $auth;
            });
        }
    }
}
