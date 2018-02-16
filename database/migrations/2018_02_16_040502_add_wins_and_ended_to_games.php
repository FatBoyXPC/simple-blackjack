<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWinsAndEndedToGames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->integer('wins_player')->unsigned()->after('cards_used')->default(0);
            $table->integer('wins_dealer')->unsigned()->after('wins_player')->default(0);
            $table->dateTime('ended_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('wins_player');
            $table->dropColumn('wins_dealer');
            $table->dropColumn('ended_at');
        });
    }
}
