<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMixtureServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mixture_service', function (Blueprint $table) {
            $table->id();
            $table->integer('mixture_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->integer('cost')->default(1);
            $table->integer('duration')->default(1);
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
        Schema::dropIfExists('mixture_service');
    }
}
