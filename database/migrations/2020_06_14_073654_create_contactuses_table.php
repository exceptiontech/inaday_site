<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactuses', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0);
            $table->integer('admin_view')->default(0);
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('subject')->nullable();
            $table->text('message')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('contactuses');
    }
}
