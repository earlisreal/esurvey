<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            //Survey Questions
            $table->increments('id');
            $table->integer('survey_page_id')->unsigned();
            $table->foreign('survey_page_id')
                ->references('id')->on('survey_pages')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('question_title');
            $table->smallInteger('order_no');
            $table->integer('question_type_id')->unsigned();
            $table->foreign('question_type_id')
                ->references('id')->on('question_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->boolean('is_mandatory')->default(false);
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
        Schema::drop('questions');
    }
}
