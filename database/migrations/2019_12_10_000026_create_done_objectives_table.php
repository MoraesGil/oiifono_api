<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoneObjectivesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'done_objectives';

    /**
     * Run the migrations.
     * @table done_objectives
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('appointment_id');
            $table->unsignedInteger('objective_id');
            $table->unsignedInteger('therapy_id');

            $table->index(["appointment_id"], 'fk_appointments_has_objectives_appointments2_idx');

            $table->index(["objective_id", "therapy_id"], 'fk_appointments_has_objectives_objectives2_idx');


            $table->foreign('appointment_id', 'fk_appointments_has_objectives_appointments2_idx')
                ->references('id')->on('appointments')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('objective_id', 'fk_appointments_has_objectives_objectives2_idx')
                ->references('id')->on('objectives')
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
