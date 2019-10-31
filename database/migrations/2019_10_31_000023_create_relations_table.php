<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->tinyInteger('order')->default(0);
            $table->tinyInteger('kinship')->comment('3 -  grand Father
2 - Father
1 - brother
0 - friend
-1 - Cousin
-2 Aunt
-3……');

            $table->foreign('person_id')->references('id')->on('people')->onDelete('no action')->onUpdate('no action');
            $table->foreign('parent_id')->references('id')->on('people')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relations', function (Blueprint $table) {
            $table->dropForeign(['person_id']);
            $table->dropForeign(['parent_id']);
        });

        Schema::drop('relations');
    }
}