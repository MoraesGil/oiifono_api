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
            $table->increments('id')->comment('ID from CRC32 label');
            $table->string('label', 100);
            $table->string('description', 255);
            $table->timestamps();
        });

        Schema::table('objectives', function (Blueprint $table) {
            $table->foreign('strategy_id')->references('id')->on('strategies')->onDelete('no action')->onUpdate('no action');
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
            $table->dropForeign(['strategy_id']);
        });

        Schema::drop('strategies');
    }
}