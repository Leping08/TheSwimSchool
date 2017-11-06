<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('season_id');
            $table->string('group_id');
            $table->string('location_id');
            $table->integer('price')->default(60);
            $table->string('days');
            $table->integer('class_size')->default(10);
            $table->integer('open_spots')->default(10);
            $table->date('class_start_date');
            $table->date('class_end_date');
            $table->date('registration_open');
            $table->dateTime('class_start_time');
            $table->dateTime('class_end_time');
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
        Schema::dropIfExists('lessons');
    }
}

