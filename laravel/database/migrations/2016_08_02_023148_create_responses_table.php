<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id')
                ->references('id')->on('surveys')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->ipAddress('source_ip')->nullable();
            $table->string('source', 20)->nullable(); //mobile, web, kiosk, manual input, etc..
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
        Schema::drop('responses');
    }
}
