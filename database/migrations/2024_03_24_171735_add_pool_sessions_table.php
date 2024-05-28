<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pool_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pool_session_id')->nullable();
            $table->string('pool_session_type');
            $table->foreignId('location_id');
            $table->foreignId('instructor_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_sessions');
    }
};
