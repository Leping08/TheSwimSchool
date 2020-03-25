<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstructorIdToPoolSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('private_pool_sessions', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable()->after('private_lesson_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('private_pool_sessions', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
