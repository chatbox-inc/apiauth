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
    	app(MailTokenEloquent::class)->up($db->getSchemaBuilder());
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
	    app(MailTokenEloquent::class)->down($db->getSchemaBuilder());
    }
}
