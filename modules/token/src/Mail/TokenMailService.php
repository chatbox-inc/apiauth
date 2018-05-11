<?php
namespace Chatbox\Token\Mail;

use Chatbox\Token\Token;
use Chatbox\Token\TokenService;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailer as IlluminateMailer;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/08
 * Time: 19:26
 */

class TokenMailService
{
    protected $token;

    protected $mailer;

    protected $shouldQueue;

    /**
     * TokenMailService constructor.
     *
     * @param $token
     */
    public function __construct(TokenService $token, array $config = [])
    {
        $this->token = $token;
        $this->mailer = array_get($config, "mail", app("mailer"));
        $this->shouldQueue = array_get($config, "shouldQueue", false);
    }

    public function inquery(string $token):?Token
    {
        return $this->token->inquery(new Token($token));
    }

    public function redeem(string $token):Token
    {
        return $this->token->publish(new Token($token));
    }

    public function send(Mailable $message, $token=null):Token
    {
        $token = new Token(
            is_callable($token)?$token():$token,
            $message
        );
        $token = $this->token->publish($token);

        $mailer = $this->mailer;
        if ($this->shouldQueue && $mailer instanceof IlluminateMailer) {
            $mailer->queue($message);
        } else {
            $mailer->send($message);
        }
        return $token;
    }
}
