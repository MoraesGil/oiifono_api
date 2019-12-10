<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'addresses';

    /**
     * Run the migrations.
     * @table addresses
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('person_id');
            $table->integer('city_id');
            $table->string('address', 225);
            $table->boolean('main')->default('0');
            $table->string('district', 100)->nullable()->comment('bairro
');
            $table->string('zipcode', 10)->nullable();
            $table->string('complements', 100)->nullable();

            $table->index(["city_id"], 'fk_enderecos_cidades1_idx');

            $table->index(["person_id"], 'fk_adresses_people1_idx');


            $table->foreign('city_id', 'fk_enderecos_cidades1_idx')
                ->references('id')->on('cities')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('person_id', 'fk_adresses_people1_idx')
                ->references('id')->on('people')
                ->onDelete('no action')
                ->onUpdate('no action');
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
