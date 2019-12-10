<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePathologiesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'pathologies';

    /**
     * Run the migrations.
     * @table pathologies
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('cid', 45);
            $table->string('label', 100)->comment('ID from CRC32 CID');
            $table->unsignedInteger('acting_area_id')->nullable();
            $table->string('description')->nullable();

            $table->index(["acting_area_id"], 'fk_pathologies_acting_areas1_idx');
            $table->timestamps();


            $table->foreign('acting_area_id', 'fk_pathologies_acting_areas1_idx')
                ->references('id')->on('acting_areas')
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
