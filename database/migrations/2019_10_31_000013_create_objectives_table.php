<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('therapy_id')->unsigned();
            $table->integer('pathology_id')->unsigned();
            $table->integer('strategy_id')->unsigned();
            $table->tinyInteger('repeat')->comment('times of repeat this session
');
            $table->tinyInteger('minutes');
            $table->string('description', 255);
        });

        Schema::table('done_objectives', function (Blueprint $table) {
            $table->foreign('objective_id')->references('id')->on('objectives')->onDelete('no action')->onUpdate('no action');
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
            $table->dropForeign(['objective_id']);
        });

        Schema::drop('objectives');
    }
}