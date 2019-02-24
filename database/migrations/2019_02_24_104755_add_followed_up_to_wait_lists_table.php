<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFollowedUpToWaitListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wait_lists', function (Blueprint $table) {
            $table->boolean('followed_up')->default(false)->after('phone');
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
            $table->dropColumn('followed_up');
        });
    }
}
