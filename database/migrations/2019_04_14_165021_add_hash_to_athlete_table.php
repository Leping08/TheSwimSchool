<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHashToAthleteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('athletes', function (Blueprint $table) {
            $table->string('hash')->after('id');
        });

        foreach (\App\Athlete::withTrashed()->get() as $athlete){
            $athlete->hash = \App\Library\Helpers\RandomString::generate();
            $athlete->save();
        }

        Schema::table('athletes', function (Blueprint $table) {
            $table->unique('hash');
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
            $table->dropColumn('hash');
        });
    }
}
