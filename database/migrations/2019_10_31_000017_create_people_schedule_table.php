<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_schedule', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->bigInteger('schedule_id');
            $table->boolean('host')->default(0);
            $table->boolean('confirmed')->default(0);

            $table->foreign('person_id')->references('id')->on('people')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people_schedule', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::drop('people_schedule');
    }
}