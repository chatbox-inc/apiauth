<?php
namespace Chatbox\MailToken\Fixture;
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
trait TokenEloquentSchema {

	public function up(Builder $builder){
		$builder->create($this->table,function (Blueprint $blueprint){
			$this->schema($blueprint);
		});
	}

	protected function schema(Blueprint $table){
		$table->increments("id");
		$table->string("token");
		$table->string("email");
		$table->string("type");
		$table->text("data");
		$table->timestamps();
		$table->softDeletes();

		// f(email, type, publish_at_ts ) -> token
		$table->unique("token");
		$table->unique(["email","type"]);
		// トークンを二重に発行しない。一つのユーザに対して有効なトークンは一つのみ
	}

	public function down(Builder $builder){
		$builder->dropIfExists($this->table);
	}
}