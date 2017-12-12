<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeForeignKeyTaskValidatedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_validated', function (Blueprint $table) {
            $table->dropForeign('task_validated_task_id_foreign');
            $table->dropForeign('task_validated_validated_transcription_id_foreign');
            $table->foreign('task_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('task_transcribed_id')->references('id')->on('task_transcribed')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_validated', function (Blueprint $table) {
            $table->dropForeign('task_validated_task_id_foreign');
            $table->dropForeign('task_validated_validated_transcription_id_foreign');
            $table->foreign('task_id')->references('id')->on('task');
            $table->foreign('task_transcribed_id')->references('id')->on('task_transcribed');
        });
    }
}
