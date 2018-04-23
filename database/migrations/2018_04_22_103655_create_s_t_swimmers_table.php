<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSTSwimmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_t_swimmers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('phone');
            $table->date('birthDate');
            $table->string('stripeChargeId')->nullable();
            $table->string('parent')->nullable();
            $table->longText('notes')->nullable();
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('emergencyName');
            $table->string('emergencyRelationship');
            $table->string('emergencyPhone');
            $table->integer('s_t_level_id')->nullable();
            $table->integer('promo_code_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_t_swimmers');
    }
}
