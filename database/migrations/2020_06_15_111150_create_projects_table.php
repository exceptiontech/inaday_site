<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0)->references('id')->on('users')->onDelete('cascade');
            $table->string('title',500)->nulable();
            $table->text('desc')->nullable();
            $table->integer('stage_id')->default(1)->references('id')->on('stages')->nullable();
            $table->integer('section_id')->default(1)->references('id')->on('sections');
            $table->integer('applykind_id')->default(1)->references('id')->on('applykinds');
            $table->integer('averagekind_id')->default(1)->references('id')->on('averagekinds')->nullable();
            $table->integer('num_team')->default(0);
            $table->integer('level_id')->default(1)->references('id')->on('levels')->nullable();

            $table->integer('cost')->default(0);
            $table->integer('costkind_id')->default(0)->references('id')->on('costkinds');

            $table->integer('reward')->nullable()->default(0);
            $table->integer('rewardkind_id')->default(0)->references('id')->on('rewardkinds')->nullable();
            $table->string('rule',500)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_approved')->default(0);
            $table->boolean('status_id')->default(1);
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
        Schema::dropIfExists('projects');
    }
}
