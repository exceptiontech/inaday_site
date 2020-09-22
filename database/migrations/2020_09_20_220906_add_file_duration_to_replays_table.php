<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileDurationToReplaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('replays', function (Blueprint $table) {
            $table->integer('replaykind_id')->nullable()->after('replay');
            $table->integer('duration')->nullable()->after('replaykind_id');
            $table->integer('is_confirmed')->nullable()->after('duration');
            $table->string('file')->nullable()->after('is_confirmed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('replays', function (Blueprint $table) {
            $table->dropColumn('replaykind_id');
            $table->dropColumn('duration');
            $table->dropColumn('is_confirmed');
            $table->dropColumn('file');
        });
    }
}
