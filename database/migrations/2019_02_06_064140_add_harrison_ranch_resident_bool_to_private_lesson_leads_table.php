<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHarrisonRanchResidentBoolToPrivateLessonLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('private_lesson_leads', function (Blueprint $table) {
            $table->boolean('hr_resident')->default(false)->after('availability');
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
            $table->dropColumn('hr_resident');
        });
    }
}
