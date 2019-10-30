<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 45);
            $table->integer('company_id')->unsigned();

            $table->foreign('company_id')->references('person_id')->on('companies')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('health_plan_id')->references('id')->on('health_plans')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('health_plans', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });


        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['health_plan_id']);
        });

        Schema::drop('health_plans');
    }
}