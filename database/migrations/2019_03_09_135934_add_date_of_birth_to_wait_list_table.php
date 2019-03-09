<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateOfBirthToWaitListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wait_lists', function (Blueprint $table) {
            $table->date('date_of_birth')->after('phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wait_lists', function (Blueprint $table) {
            $table->dropColumn('date_of_birth');
        });
    }
}
