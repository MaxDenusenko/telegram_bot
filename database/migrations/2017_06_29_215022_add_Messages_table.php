<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chat_id');
            $table->string('chat_label');
            $table->text('text');
            $table->string('sender');
            $table->tinyInteger('read');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Messages', function (Blueprint $table) {
            //
        });
    }
}
