<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 255);
            $table->string('password', 255);
            $table->boolean('is_superadmin')->default(0);
            $table->integer('person_id')->unsigned()->nullable();
            $table->string('picture', 200)->nullable();
            $table->softDeletes();
            $table->timestamps();

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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
        });

        Schema::drop('users');
    }
}