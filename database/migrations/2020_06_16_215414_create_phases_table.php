<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phases', function (Blueprint $table) {
            $table->id();
            $table->integer('target_clients')->default(0);
            $table->integer('target_sales')->default(0);
            $table->integer('target_profits')->default(0);
            $table->boolean('next_status')->default(0);
            $table->integer('readinesskind_id')->default(0)->references('id')->on('readinesskinds')->nullable();
            $table->integer('project_id')->default(0)->references('id')->on('projects');
            $table->dateTime('date')->nullable();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('phases');
    }
}
