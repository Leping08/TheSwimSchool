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
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('age');
            $table->boolean('paid')->default(0);
            $table->string('stripechargeid')->nullable();
            $table->string('parent')->nullable();
            $table->longText('notes')->nullable();
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('emergencyName');
            $table->string('emergencyRelationship');
            $table->string('emergencyPhone');
            $table->integer('lesson_id');
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
