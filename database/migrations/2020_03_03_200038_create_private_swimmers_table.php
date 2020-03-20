<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivateSwimmersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('private_swimmers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->date('birth_date');
            $table->string('stripe_charge_id')->nullable();
            $table->string('parent')->nullable();
            $table->longText('notes')->nullable();
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('emergency_name');
            $table->string('emergency_relationship');
            $table->string('emergency_phone');
            $table->integer('private_lesson_id')->nullable();
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
        Schema::dropIfExists('private_swimmers');
    }
}
