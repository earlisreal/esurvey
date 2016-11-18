<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')
                ->references('id')->on('user_roles')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')
                ->references('id')->on('modules')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('can_read')->default(false);
            $table->boolean('can_write')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_modules');
    }
}
