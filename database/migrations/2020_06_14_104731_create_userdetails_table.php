<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('jobtype_id')->nullable();
            $table->integer('level_id')->nullable();
            $table->integer('prefer_id')->nullable();
            $table->integer('costkind_id')->nullable();
            $table->integer('applykind_id')->nullable();
            $table->integer('averagekind_id')->nullable();
            $table->string('average_cost')->nullable();
            $table->integer('readinesskind_id')->nullable();
            $table->integer('rewardkind_id')->nullable();
            $table->dateTime('readiness_date')->nullable();
            $table->date('brith_day')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('position')->nullable();
            $table->string('time_start')->nullable();
            $table->text('notes')->nullable();
            $table->string('cv_file')->nullable();
            $table->string('avater')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('userdetails');
    }
}
