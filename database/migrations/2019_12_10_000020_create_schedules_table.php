<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'schedules';

    /**
     * Run the migrations.
     * @table schedules
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('person_id');
            $table->unsignedInteger('doctor_id');
            $table->timestamp('start_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('confirmed')->default('0');
            $table->bigInteger('parent_id')->nullable()->comment('id do pai
');
            $table->string('absence_by')->nullable()->default('NULL')->comment('NULL == not
empty == not justified
value == justified');

            $table->index(["person_id"], 'fk_schedules_individuals1_idx');

            $table->index(["parent_id"], 'fk_schedules_schedules1_idx');

            $table->index(["doctor_id"], 'fk_schedules_doctors1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('parent_id', 'fk_schedules_schedules1_idx')
                ->references('id')->on('schedules')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('person_id', 'fk_schedules_individuals1_idx')
                ->references('person_id')->on('individuals')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('doctor_id', 'fk_schedules_doctors1_idx')
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
