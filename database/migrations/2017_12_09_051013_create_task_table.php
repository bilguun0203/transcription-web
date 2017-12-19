<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('audio_id')->unsigned();
            $table->char('type', 1)->nullable(false)->default('t');
            $table->integer('user_id')->unsigned()->nullable(true);
            $table->char('status', 1)->nullable(false);
            $table->timestamps();

            $table->foreign('audio_id')->references('id')->on('audio')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task');
    }
}
