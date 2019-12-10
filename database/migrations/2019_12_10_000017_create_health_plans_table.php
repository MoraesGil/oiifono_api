<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthPlansTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'health_plans';

    /**
     * Run the migrations.
     * @table health_plans
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('label', 45);
            $table->unsignedInteger('company_id')->nullable();

            $table->index(["company_id"], 'fk_health_plans_companies1_idx');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('company_id', 'fk_health_plans_companies1_idx')
                ->references('person_id')->on('companies')
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
