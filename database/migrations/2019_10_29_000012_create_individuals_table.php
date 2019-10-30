<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individuals', function (Blueprint $table) {
            $table->increments('person_id');
            $table->date('birthdate');
            $table->char('sex', 1);
            $table->string('cpf', 45);
            $table->string('rg', 45)->nullable();
            $table->string('disabilities', 100)->nullable();
            $table->date('deathdate')->nullable();
        });

        Schema::table('hospitalization', function (Blueprint $table) {
            $table->foreign('patient_id')->references('person_id')->on('individuals')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('hospitalization', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
        });

        Schema::drop('individuals');
    }
}