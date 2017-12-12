<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignKeyTaskTranscribedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_transcribed', function (Blueprint $table) {
            $table->dropForeign('task_transcribed_task_id_foreign');
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_transcribed', function (Blueprint $table) {
            $table->dropForeign('task_transcribed_task_id_foreign');
            $table->foreign('task_id')->references('id')->on('task');
        });
    }
}
