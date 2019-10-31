<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTherapiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hospitalization_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->string('description', 255);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('hospitalization_id')->references('id')->on('hospitalization')->onDelete('no action')->onUpdate('no action');
            $table->foreign('doctor_id')->references('person_id')->on('doctors')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('objectives', function (Blueprint $table) {
            $table->foreign('therapy_id')->references('id')->on('therapies')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->foreign('therapy_id')->references('id')->on('therapies')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('therapies', function (Blueprint $table) {
            $table->dropForeign(['hospitalization_id']);
            $table->dropForeign(['doctor_id']);
        });


        Schema::table('objectives', function (Blueprint $table) {
            $table->dropForeign(['therapy_id']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['therapy_id']);
        });

        Schema::drop('therapies');
    }
}