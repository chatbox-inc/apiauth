<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/09
 * Time: 19:34
 */

namespace Chatbox\ApiAuth\Tests\Scenario;

use Chatbox\ApiAuth\Mail\ChangeEmailMailMailable;
use Chatbox\ApiAuth\Tests\Request\Request;
use Chatbox\ApiAuth\Tests\Response;

trait ChangeEmailScenario
{
    abstract protected function response():Response;

    public function scenarioChangeEmailMailSend($email)
    {
        # メール送信
        Request::send_change_email($email)->run();
        $this->response()->isOK()->et()->hasMessage();
        $message = $this->response()->message();
        assert($message instanceof ChangeEmailMailMailable);

        # トークンの問い合わせ
        Request::inquery_change_email($message->token())->run();
        $this->response()->isOK()->et()->hasMessage();
        $message = $this->response()->message();
        assert($message instanceof ChangeEmailMailMailable);

        return $message->token();
    }

    public function scenarioChangeEmail($token, $credential)
    {
        # トークンを使ってリセットを実施
        Request::auth_change_email($token)->run();
        $this->response()->isOK();

        # 実施したリセットパスでログイン出来ること
        Request::login($credential)->run();
        $this->response()->isOK()->et()->hasToken();
    }
}
