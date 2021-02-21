<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaysOfTheWeek extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('days_of_the_weeks')->insert([
            'day' => 'Monday',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Tuesday',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Wednesday',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Thursday',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Friday',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Saturday',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Sunday',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
