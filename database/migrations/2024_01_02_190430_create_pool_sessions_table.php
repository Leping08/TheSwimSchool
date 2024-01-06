<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_sessions', function (Blueprint $table) {
            $table->id('id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->string('pool_session_type');
            $table->unsignedInteger('pool_session_type_id');
            $table->unsignedInteger('location_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pool_sessions');
    }
};
