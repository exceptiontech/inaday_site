<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_question', function (Blueprint $table) {
            $table->id();
            $table->integer('interview_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('qoption_id')->default(0);
            $table->integer('is_correct')->default(0);
            $table->text('answer')->nullable();
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
        Schema::dropIfExists('interview_question');
    }
}
