<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersettings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('blog_notifications')->default('0');
            $table->string('offer_notifications')->default('0');
            $table->string('booking_notifications')->default('0');
            $table->string('review_notifications')->default('0');
            $table->string('team_notifications')->default('0');
            $table->string('profile_notifications')->default('0');
            $table->string('favorite_notifications')->default('0');
            $table->string('replay_notifications')->default('0');
            $table->string('message_notifications')->default('0');
            $table->string('support_notifications')->default('0');
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
        Schema::dropIfExists('usersettings');
    }
}
