<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->increments('uf');
            $table->string('name', 50);
        });

        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('uf')->references('uf')->on('states')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('cities', function (Blueprint $table) {
            $table->dropForeign(['uf']);
        });

        Schema::drop('states');
    }
}