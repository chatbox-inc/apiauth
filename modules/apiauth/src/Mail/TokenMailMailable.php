<?php
namespace Chatbox\ApiAuth\Mail;

use Illuminate\Mail\Mailable;

/**
 * 各種メールテンプレートの原型
 * 制御側で型チェックを行うため、そのまま利用する事はしない。
 *
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 16:19
 */
abstract class TokenMailMailable extends Mailable {

	protected $type;

	public $template;

	public $token;

	/**
	 * テンプレート名は設定経由で注入したい。
	 *
	 * @param $template
	 * @param $token
	 */
	public function __construct( $template) {
		$this->template = $template;
	}

	public function isTypeOf($type){
		return $type === $this->type;
	}

	public function token(){
		if($this->token){
			return $this->token;
		}else{
			$this->token = sha1(mt_rand(0,9999999999));
		}
	}

	public function build()
	{
		return $this->view($this->template)
		            ->with("token",$this->token);
	}
}