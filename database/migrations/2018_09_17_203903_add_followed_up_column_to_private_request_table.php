<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFollowedUpColumnToPrivateRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('private_lesson_leads', function (Blueprint $table) {
            $table->boolean('followed_up')->default(false)->after('availability');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->boolean('followed_up')->default(false)->after('message');
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
            $table->dropColumn('followed_up');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('followed_up');
        });
    }
}
