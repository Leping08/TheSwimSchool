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
        Schema::create('pool_session_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('pool_session_id');
            $table->unsignedInteger('swimmable_id');
            $table->string('swimmable_type');
            $table->boolean('attended')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pool_session_attendance');
    }
};
