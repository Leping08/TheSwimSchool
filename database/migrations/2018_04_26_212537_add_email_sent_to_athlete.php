<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailSentToAthlete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('athletes', function (Blueprint $table) {
            $table->boolean('s_t_sign_up_email')->after('s_t_level')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('athletes', function (Blueprint $table) {
            $table->dropColumn('s_t_sign_up_email');
        });
    }
}
