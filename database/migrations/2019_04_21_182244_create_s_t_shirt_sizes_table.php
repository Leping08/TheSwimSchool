<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTShirtSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_t_shirt_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->text('size');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('s_t_swimmers', function (Blueprint $table) {
            $table->unsignedBigInteger('s_t_shirt_size_id')->nullable()->after('s_t_season_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_t_shirt_sizes');

        Schema::table('s_t_swimmers', function (Blueprint $table) {
            $table->dropColumn('s_t_shirt_size_id');
        });
    }
}
