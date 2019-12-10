<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectivesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'objectives';

    /**
     * Run the migrations.
     * @table objectives
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('therapy_id');
            $table->unsignedInteger('pathology_id');
            $table->unsignedInteger('strategy_id');
            $table->tinyInteger('repeat')->comment('times of repeat this session
');
            $table->tinyInteger('minutes')->default('15');
            $table->string('description', 100);

            $table->index(["strategy_id"], 'fk_therapeutic_sessions_estrategies1_idx');

            $table->index(["therapy_id"], 'fk_therapeutic_plans_has_objectives_therapeutic_plans1_idx');

            $table->index(["pathology_id"], 'fk_therapeutic_sessions_pathologies1_idx');


            $table->foreign('therapy_id', 'fk_therapeutic_plans_has_objectives_therapeutic_plans1_idx')
                ->references('id')->on('therapies')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('pathology_id', 'fk_therapeutic_sessions_pathologies1_idx')
                ->references('id')->on('pathologies')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('strategy_id', 'fk_therapeutic_sessions_estrategies1_idx')
                ->references('id')->on('strategies')
                ->onDelete('no action')
                ->onUpdate('cascade');
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
