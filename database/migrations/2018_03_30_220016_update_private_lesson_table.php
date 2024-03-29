<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePrivateLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('private_lesson_leads', function (Blueprint $table) {
            $table->renameColumn('name', 'swimmer_name');
            $table->date('swimmer_birth_date')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('private_lesson_leads', function (Blueprint $table) {
            $table->renameColumn('swimmer_name', 'name');
            $table->dropColumn('swimmer_birth_date');
        });
    }
}
