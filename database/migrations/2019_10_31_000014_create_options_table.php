<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table) {
            $table->increments('id')->comment('PHP CRC32');
            $table->string('label', 100);
            $table->tinyInteger('lines')->default(0);
            $table->integer('parent_id')->unsigned()->nullable();

            $table->foreign('parent_id')->references('id')->on('options')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('evolutions', function (Blueprint $table) {
            $table->foreign('options_id')->references('id')->on('options')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });


        Schema::table('evolutions', function (Blueprint $table) {
            $table->dropForeign(['options_id']);
        });

        Schema::drop('options');
    }
}