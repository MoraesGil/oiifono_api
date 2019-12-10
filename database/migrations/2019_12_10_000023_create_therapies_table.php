<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTherapiesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'therapies';

    /**
     * Run the migrations.
     * @table therapies
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('hospitalization_id');
            $table->unsignedInteger('doctor_id');
            $table->tinyInteger('times_week')->default('1');
            $table->tinyInteger('max_minutes')->default('60');
            $table->string('description')->comment('general objective');

            $table->index(["doctor_id"], 'fk_therapeutic_plans_doctors1_idx');

            $table->index(["hospitalization_id"], 'fk_therapeutic_plans_patients1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('hospitalization_id', 'fk_therapeutic_plans_patients1_idx')
                ->references('id')->on('hospitalizations')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('doctor_id', 'fk_therapeutic_plans_doctors1_idx')
                ->references('person_id')->on('doctors')
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
