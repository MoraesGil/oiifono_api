<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'options';

    /**
     * Run the migrations.
     * @table options
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('PHP CRC32');
            $table->string('label', 100);
            $table->tinyInteger('lines')->default('0')->comment('0 - none lines
1 - input equivalent
2 - textarea equivalent

');
            $table->unsignedInteger('parent_id')->nullable();

            $table->index(["parent_id"], 'fk_options_options1_idx');


            $table->foreign('parent_id', 'fk_options_options1_idx')
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
