<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionOptionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'question_options';

    /**
     * Run the migrations.
     * @table question_options
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('protocol_question_id');
            $table->unsignedInteger('option_id');
            $table->integer('order')->default('0');
            $table->tinyInteger('group')->nullable()->default('NULL');

            $table->index(["option_id"], 'fk_protocol_questions_has_options1_options1_idx');

            $table->index(["protocol_question_id"], 'fk_protocol_questions_has_options1_protocol_questions1_idx');


            $table->foreign('protocol_question_id', 'fk_protocol_questions_has_options1_protocol_questions1_idx')
                ->references('id')->on('protocol_questions')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('option_id', 'fk_protocol_questions_has_options1_options1_idx')
                ->references('id')->on('options')
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
