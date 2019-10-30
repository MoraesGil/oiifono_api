<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoneObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('done_objectives', function (Blueprint $table) {
            $table->integer('appointment_id')->unsigned();
            $table->integer('objective_id')->unsigned();
            $table->integer('therapy_id')->unsigned();

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
        Schema::table('done_objectives', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
        });

        Schema::drop('done_objectives');
    }
}