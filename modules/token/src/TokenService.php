<?php
namespace Chatbox\Token;

/**
 * トークン操作のインターフェイス
 * User: mkkn
 * Date: 2018/04/08
 * Time: 4:00
 */
interface TokenService {

	/**
	 * トークンの新規発行
	 *
	 * トークンは外部から注入するか内部で発行するか利用時に選べるが、
	 * Token が token を保有している場合には必ずそれを採用すること
	 */
	public function publish(Token $token,$_token=null):Token;

	/**
	 * トークンの買い戻し
	 *
	 * トークンを無効化する。
	 * 返り値をそのまま publish に突っ込んで、同じトークンを再生成出来る。
	 */
	public function redeem(Token $token):?Token;

	/**
	 * トークンの照会
	 */
	public function inquery(Token $token): ?Token;
}