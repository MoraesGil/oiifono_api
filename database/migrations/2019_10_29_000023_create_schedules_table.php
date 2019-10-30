<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('label', 45);
            $table->tinyInteger('type')->default(0)->comment('0 evolution
1 interview
2 evaluation');
            $table->timestamp('start_at')->default(CURRENT_TIMESTAMP);
            $table->timestamp('end_at')->default(CURRENT_TIMESTAMP);
            $table->integer('therapy_id')->unsigned()->nullable();
            $table->bigInteger('parent_id')->nullable()->comment('id do pai
');
            $table->string('absence_by', 255)->nullable()->default(NULL)->comment('NULL == not
empty == not justified
value == justified');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('schedules')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('people_schedule', function (Blueprint $table) {
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });


        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
        });

        Schema::table('people_schedule', function (Blueprint $table) {
            $table->dropForeign(['schedule_id']);
        });

        Schema::drop('schedules');
    }
}