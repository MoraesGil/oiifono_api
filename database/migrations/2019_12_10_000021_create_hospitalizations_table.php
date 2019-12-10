<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalizationsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'hospitalizations';

    /**
     * Run the migrations.
     * @table hospitalizations
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
            $table->unsignedInteger('health_plan_id')->nullable();
            $table->timestamp('discharged')->nullable();
            $table->string('discharged_by')->nullable();
            $table->unsignedInteger('discharged_doctor_id')->nullable();

            $table->index(["discharged_doctor_id"], 'fk_hospitalization_doctors1_idx');

            $table->index(["person_id"], 'fk_patients_individuals1_idx');

            $table->index(["health_plan_id"], 'fk_patients_health_plans1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('person_id', 'fk_patients_individuals1_idx')
                ->references('person_id')->on('individuals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('health_plan_id', 'fk_patients_health_plans1_idx')
                ->references('id')->on('health_plans')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('discharged_doctor_id', 'fk_hospitalization_doctors1_idx')
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
