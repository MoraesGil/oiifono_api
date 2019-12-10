<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'relations';

    /**
     * Run the migrations.
     * @table relations
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('person_id');
            $table->unsignedInteger('parent_id');
            $table->tinyInteger('order')->default('0');
            $table->tinyInteger('kinship')->default('0')->comment('3 -  grand Father
2 - Father
1 - brother
0 - friend
-1 - Cousin
-2 Aunt
-3……');
            $table->string('contact', 15);

            $table->index(["person_id"], 'fk_people_has_people_people1_idx');

            $table->index(["parent_id"], 'fk_people_has_people_people2_idx');


            $table->foreign('person_id', 'fk_people_has_people_people1_idx')
                ->references('id')->on('people')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('parent_id', 'fk_people_has_people_people2_idx')
                ->references('id')->on('people')
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
