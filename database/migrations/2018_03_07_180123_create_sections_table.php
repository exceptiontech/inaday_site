<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title');
            $table->string('image')->nullable();                     
            $table->string('icon')->nullable();
            $table->string('slug');
            $table->text('desc')->nullable();            
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('sections');
    }
}
