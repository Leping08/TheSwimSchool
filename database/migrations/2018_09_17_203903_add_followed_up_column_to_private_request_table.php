<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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

        foreach (\App\Models\PrivateLessonLead::all() as $private) {
            $private->followed_up = 1;
            $private->save();
        }

        Schema::table('contacts', function (Blueprint $table) {
            $table->boolean('followed_up')->default(false)->after('message');
        });

        foreach (\App\Models\Contact::all() as $contact) {
            $contact->followed_up = 1;
            $contact->save();
        }
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
