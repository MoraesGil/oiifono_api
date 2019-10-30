<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->char('uf', 2);
        });

        Schema::table('adresses', function (Blueprint $table) {
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('adresses', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
        });

        Schema::drop('cities');
    }
}