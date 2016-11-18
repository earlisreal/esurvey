<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_id')->unsigned();
            $table->foreign('survey_id')
                ->references('id')->on('surveys')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('open')->default(true);
            $table->text('closed_message')->nullable();
            $table->boolean('multiple_responses')->default(false);
            $table->integer('target_responses')->nullable();
            $table->date('date_close')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('survey_options');
    }
}
