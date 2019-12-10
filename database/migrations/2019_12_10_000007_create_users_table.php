<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->boolean('is_superadmin')->default('0');
            $table->unsignedInteger('person_id')->nullable();
            $table->string('picture', 200)->nullable();

            $table->index(["person_id"], 'fk_users_people1_idx');

            $table->unique(["email"], 'users_email_unique');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('person_id', 'fk_users_people1_idx')
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
