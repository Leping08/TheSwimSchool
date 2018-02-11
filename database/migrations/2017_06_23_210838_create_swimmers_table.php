<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSwimmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('swimmers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('email');
            $table->string('phone');
            $table->integer('birthDate');
            $table->boolean('paid')->default(0);
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
            $table->integer('lesson_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('swimmers');
    }
}
