<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('person_id');
            $table->string('register', 30);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('person_id')->on('doctors')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });

        Schema::drop('doctors');
    }
}