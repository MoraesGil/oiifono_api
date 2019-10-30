<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStrategiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('strategies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 100);
            $table->string('description', 255);
        });

        Schema::table('objectives', function (Blueprint $table) {
            $table->foreign('estrategy_id')->references('id')->on('strategies')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('objectives', function (Blueprint $table) {
            $table->dropForeign(['estrategy_id']);
        });

        Schema::drop('strategies');
    }
}