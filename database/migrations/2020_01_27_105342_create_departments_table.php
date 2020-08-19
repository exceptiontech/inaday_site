<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->text('desc')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->default('blog');
            $table->string('image')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('is_active')->default(1);
            $table->integer('order')->default('0');
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('departments');
    }
}
