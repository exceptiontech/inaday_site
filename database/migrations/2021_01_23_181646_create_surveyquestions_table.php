<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyquestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveyquestions', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('desc')->nullable();
            $table->string('type')->default('multi')->nullable(); // multi or paragraph
            $table->boolean('is_active')->default(1);
            $table->integer('survey_id')->references('id')->on('surveys')->onDelete('cascade');
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
        Schema::dropIfExists('surveyquestions');
    }
}
