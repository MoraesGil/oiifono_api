<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->comment('0 evolution
1 interview
2 evaluation');
            $table->timestamp('created_at')->default(CURRENT_TIMESTAMP);
            $table->string('title', 45);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('protocol_id')->references('id')->on('protocols')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('protocol_questions', function (Blueprint $table) {
            $table->foreign('protocol_id')->references('id')->on('protocols')->onDelete('no action')->onUpdate('no action');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['protocol_id']);
        });

        Schema::table('protocol_questions', function (Blueprint $table) {
            $table->dropForeign(['protocol_id']);
        });

        Schema::drop('protocols');
    }
}