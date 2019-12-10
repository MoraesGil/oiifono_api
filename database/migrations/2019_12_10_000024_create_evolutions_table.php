<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvolutionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'evolutions';

    /**
     * Run the migrations.
     * @table evolutions
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('appointment_id');
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('option_id');
            $table->string('answer')->nullable();

            $table->index(["appointment_id"], 'fk_appointments_has_questions_appointments1_idx');

            $table->index(["question_id"], 'fk_appointments_has_questions_questions1_idx');

            $table->index(["option_id"], 'fk_appointments_has_questions_options1_idx');


            $table->foreign('appointment_id', 'fk_appointments_has_questions_appointments1_idx')
                ->references('id')->on('appointments')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('question_id', 'fk_appointments_has_questions_questions1_idx')
                ->references('id')->on('questions')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('option_id', 'fk_appointments_has_questions_options1_idx')
                ->references('id')->on('options')
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
