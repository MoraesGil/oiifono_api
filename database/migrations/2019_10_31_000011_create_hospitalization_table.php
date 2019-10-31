<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned();
            $table->integer('health_plan_id')->unsigned()->nullable();
            $table->timestamp('discharged')->nullable();
            $table->text('discharged_by')->nullable();
            $table->integer('discharged_doctor_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('health_plan_id')->references('id')->on('health_plans')->onDelete('no action')->onUpdate('no action');
            $table->foreign('discharged_doctor_id')->references('person_id')->on('doctors')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('hospitalization_id')->references('id')->on('hospitalization')->onDelete('cascade')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hospitalization', function (Blueprint $table) {
            $table->dropForeign(['health_plan_id']);
            $table->dropForeign(['discharged_doctor_id']);
        });


        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['hospitalization_id']);
        });

        Schema::drop('hospitalization');
    }
}