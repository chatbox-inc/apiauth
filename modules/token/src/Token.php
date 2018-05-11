<?php
namespace Chatbox\Token;

use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;

class Token
{
    use SerializesModels;

    public $token;

    public $data;

    public $createdAt;

    public function __construct($token, $data=[], Carbon $createdAt = null)
    {
        $this->token     = $token;
        $this->data      = $data;
        $this->createdAt = $createdAt ?: Carbon::now();
    }
}
