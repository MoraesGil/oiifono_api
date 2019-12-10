<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'appointments';

    /**
     * Run the migrations.
     * @table appointments
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('hospitalization_id')->comment('patient 
');
            $table->string('overview', 200);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('health_plan_id')->nullable();
            $table->bigInteger('schedule_id')->nullable();
            $table->unsignedInteger('protocol_id')->nullable();

            $table->index(["doctor_id"], 'fk_appointmentable_doctors1_idx');

            $table->index(["hospitalization_id"], 'fk_appointmentable_patients1_idx');

            $table->index(["health_plan_id"], 'fk_appointmentable_health_plans1_idx');

            $table->index(["protocol_id"], 'fk_appointments_protocols1_idx');

            $table->index(["schedule_id"], 'fk_appointmentable_schedules1_idx');
            $table->softDeletes();


            $table->foreign('doctor_id', 'fk_appointmentable_doctors1_idx')
                ->references('person_id')->on('doctors')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('hospitalization_id', 'fk_appointmentable_patients1_idx')
                ->references('id')->on('hospitalizations')
                ->onDelete('cascade')
                ->onUpdate('no action');

            $table->foreign('health_plan_id', 'fk_appointmentable_health_plans1_idx')
                ->references('id')->on('health_plans')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('schedule_id', 'fk_appointmentable_schedules1_idx')
                ->references('id')->on('schedules')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('protocol_id', 'fk_appointments_protocols1_idx')
                ->references('id')->on('protocols')
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
