<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaysOfTheWeekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('days_of_the_weeks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day');
            $table->timestamps();
        });

        Schema::create('days_of_the_week_lesson', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lesson_id');
            $table->integer('days_of_the_week_id');
            $table->timestamps();
        });

        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('days_of_the_weeks');
        Schema::dropIfExists('days_of_the_week_lesson');
    }
}
