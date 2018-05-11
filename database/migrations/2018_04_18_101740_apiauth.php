<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Apiauth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	/** @var \Illuminate\Database\DatabaseManager $db */
    	$db = app("db");
	    Schema::create('cache', function ($table) {
		    $table->string('key')->unique();
		    $table->text('value');
		    $table->integer('expiration');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    /** @var \Illuminate\Database\DatabaseManager $db */
	    $db = app("db");
	    Schema::dropIfExists("cache");
    }
}
