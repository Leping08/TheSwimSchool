<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInstructorIdToLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->unsignedInteger('instructor_id')->nullable()->after('location_id');
        });

        Schema::table('private_pool_sessions', function (Blueprint $table) {
            $table->renameColumn('user_id', 'instructor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn('instructor_id');
        });

        Schema::table('private_pool_sessions', function (Blueprint $table) {
            $table->renameColumn('instructor_id', 'user_id');
        });
    }
}
