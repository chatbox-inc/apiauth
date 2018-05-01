<?php
namespace Chatbox\ApiAuth;

use Chatbox\ApiAuth\Http\Controllers\MailController;
use Chatbox\ApiAuth\Http\Controllers\ProfileController;
use Chatbox\ApiAuth\Http\Controllers\AuthController;

/**
 * タダのコンテナとしてのみ利用
 */
trait SetupRoute
{
    public function route($router)
    {
        $router->group([], function ($router) {
            $router->get("profile", ProfileController::class."@me");
            $router->post("profile", ProfileController::class."@create");
            $router->patch("profile", ProfileController::class."@update");
            $router->delete("profile", ProfileController::class."@delete");

            $router->post("/auth/login", AuthController::class."@login");
            $router->post("/auth/logout", AuthController::class."@logout");
            $router->post("/auth/reset_pass", AuthController::class."@reset_pass");
            $router->post("/auth/change_email", AuthController::class."@change_email");

            // type(invite,reset_pass,change_email)
            $router->get("mail/{type}", MailController::class."@inquery");
            $router->post("mail/{type}", MailController::class."@send");
        });
    }

    protected function setupRoute($router)
    {
    }
}
