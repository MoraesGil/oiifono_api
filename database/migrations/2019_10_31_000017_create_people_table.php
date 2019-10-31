<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('nickname', 200)->nullable();
            $table->string('picture', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('addresses', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('people')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('availabilities', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('people')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('people')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('people')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('individuals', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('people')->onDelete('no action')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('availabilities', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::table('individuals', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::drop('people');
    }
}