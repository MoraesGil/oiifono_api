<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathologiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pathologies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label', 100);
            $table->integer('acting_area_id')->unsigned()->nullable();
            $table->string('description', 255)->nullable();
            $table->string('cid', 45)->nullable();

            $table->foreign('acting_area_id')->references('id')->on('acting_areas')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('objectives', function (Blueprint $table) {
            $table->foreign('pathology_id')->references('id')->on('pathologies')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pathologies', function (Blueprint $table) {
            $table->dropForeign(['acting_area_id']);
        });


        Schema::table('objectives', function (Blueprint $table) {
            $table->dropForeign(['pathology_id']);
        });

        Schema::drop('pathologies');
    }
}