<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_t_seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('dates');
            $table->boolean('current_season');
            $table->timestamps();
        });

        Schema::table('s_t_swimmers', function (Blueprint $table) {
            $table->unsignedInteger('s_t_season_id')->after('s_t_level_id');
        });

        Schema::table('tryouts', function (Blueprint $table) {
            $table->unsignedInteger('s_t_season_id')->after('location_id');
        });

        Schema::table('athletes', function (Blueprint $table) {
            $table->unsignedInteger('s_t_season_id')->after('s_t_level');
        });

        Schema::table('tryouts', function (Blueprint $table) {
            $table->dropColumn('season_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_t_seasons');

        Schema::table('s_t_swimmers', function (Blueprint $table) {
            $table->dropColumn('s_t_season_id');
        });

        Schema::table('tryouts', function (Blueprint $table) {
            $table->dropColumn('s_t_season_id');
        });

        Schema::table('athletes', function (Blueprint $table) {
            $table->dropColumn('s_t_season_id');
        });
    }
}
