<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolQuestionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'protocol_questions';

    /**
     * Run the migrations.
     * @table protocol_questions
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('protocol_id');
            $table->unsignedInteger('question_id');
            $table->integer('order')->default('0');

            $table->index(["protocol_id"], 'fk_protocols_has_questions_protocols1_idx');

            $table->index(["question_id"], 'fk_protocols_has_questions_questions1_idx');


            $table->foreign('protocol_id', 'fk_protocols_has_questions_protocols1_idx')
                ->references('id')->on('protocols')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('question_id', 'fk_protocols_has_questions_questions1_idx')
                ->references('id')->on('questions')
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
