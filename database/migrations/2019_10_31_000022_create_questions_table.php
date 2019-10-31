<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 45);
            $table->tinyInteger('lines')->default(0);
            $table->string('description', 255)->nullable();
        });

        Schema::table('evolutions', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('protocol_questions', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('question_options', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('evolutions', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });

        Schema::table('protocol_questions', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });

        Schema::table('question_options', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });

        Schema::drop('questions');
    }
}