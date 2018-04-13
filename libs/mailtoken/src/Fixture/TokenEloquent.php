<?php
namespace Chatbox\MailToken\Guide;
use Carbon\Carbon;
use Chatbox\MailToken\Exceptions\TokenNotFoundException;
use Chatbox\MailToken\Mailable\TokenMessageMailable;
use Chatbox\MailToken\TokenService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2018/04/08
 * Time: 22:24
 */
class TokenEloquent extends Model implements TokenService {

	use SoftDeletes;
	use TokenEloquentSchema;

	protected $table = "";

	protected function generateToken(string $email,string $type,Carbon $published_at){
		$seed = json_encode([
			"email" => $email,
			"type" => $type,
			"published_at" => $published_at->timestamp,
		]);
		return sha1($seed);
	}

	public function publish( string $email, $data,string $type = "default" ): string {
		$tokenModel = $this->findByEmailAndType($email,$type);
		if($tokenModel){
			$tokenModel->touch();
		}else{
			$now = Carbon::now();
			$tokenModel->token = $this->generateToken($email,$type,$now);
			$tokenModel->email = $email;
			$tokenModel->type = $type;
			$tokenModel->data = $data;
		}
		return $tokenModel->token;

	}

	public function redeem( string $token,string $type = "default" ):void {
		$tokenModel = $this->findByToken($token,$type);
		$tokenModel->delete();
	}

	public function inquery( string $token,string $type = "default" ): TokenMessageMailable {
		$tokenModel = $this->findByToken($token,$type);
		return $tokenModel->data;
	}

	protected function findByToken($token,$type):TokenEloquent{
		$tokenModel = $this->where([
			"token" => $token,
			"type" => $type
		])->first();
		if($tokenModel){
			return $tokenModel;
		}
		throw new TokenNotFoundException();

	}

	/**
	 * 重複チェック目的での利用であるケースが多いため、
	 * Exception 投げない
	 * @param $email
	 * @param $type
	 *
	 * @return mixed
	 */
	protected function findByEmailAndType($email,$type){
		$tokenModel = $this->where([
			"email" => $email,
			"type" => $type
		])->first();
		return $tokenModel;
	}


}