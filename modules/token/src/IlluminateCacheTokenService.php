<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/05/08
 * Time: 16:21
 */

namespace Chatbox\Token;


use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Cache;

class IlluminateCacheTokenService implements TokenService {

	/** @var Repository */
	protected $cache;

	/**
	 * IlluminateCacheTokenService constructor.
	 *
	 * @param $cache
	 */
	public function __construct( $cache = null ) {
		/** @var Repository cache */
		$cache = $cache ?: app("cache");
		$this->cache = $cache;
	}

	public function publish( Token $token, $_token = null ): Token {
		if ($this->cache->has($token->token)) {
			throw new \Exception("invalid token already used");
		}
		$this->cache->forever($token->token,$token);
		return $token;
	}

	public function redeem( Token $token ): ?Token {
		$token = $this->cache->pull($token->token);
		return $token;
	}

	public function inquery( Token $token ): ?Token {
		$_token = $this->cache->get($token->token);
		$_token = $_token;
		return $_token;
	}


}