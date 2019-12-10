<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndividualsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'individuals';

    /**
     * Run the migrations.
     * @table individuals
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('person_id');
            $table->string('cpf', 45)->nullable()->comment('no every patient has CPF');
            $table->date('birthdate')->nullable();
            $table->char('gender', 1)->nullable();
            $table->string('rg', 45)->nullable();
            $table->string('disabilities', 100)->nullable();
            $table->date('deathdate')->nullable();

            $table->unique(["cpf"], 'cpf_UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
