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
            $table->string('season');
            $table->integer('price')->default(60);
            $table->string('ages');
            $table->longText('description');
            $table->string('location');
            $table->string('days');
            $table->string('class_type');
            $table->integer('class_size')->default(10);
            $table->integer('open_spots')->default(10);
            $table->dateTime('class_start_date');
            $table->dateTime('class_end_date');
            $table->dateTime('registration_open');
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

