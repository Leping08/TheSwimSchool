<?php

use Illuminate\Database\Seeder;

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
            'day' => 'Sunday',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Monday',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Tuesday',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Wednesday',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Thursday',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Friday',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);

        DB::table('days_of_the_weeks')->insert([
            'day' => 'Saturday',
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        ]);
    }
}
