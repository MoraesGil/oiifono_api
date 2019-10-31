<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evolutions', function (Blueprint $table) {
            $table->integer('appointment_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('options_id')->unsigned()->nullable();
            $table->string('answer', 200)->nullable();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('no action')->onUpdate('no action');
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
            $table->dropForeign(['appointment_id']);
        });

        Schema::drop('evolutions');
    }
}