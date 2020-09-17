<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixtures', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('desc')->nullable();
            $table->integer('cost')->default(0);
            $table->integer('section_id')->nullable();
            $table->integer('duration')->default(1);
            $table->string('image')->nullable();
            $table->integer('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_approved')->default(0);
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
        Schema::dropIfExists('mixtures');
    }
}
