<?php

use Illuminate\Database\Seeder;

class Seasons extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //2017
        DB::table('seasons')->insert([
            'year' => '2017',
            'season' => 'Fall',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('seasons')->insert([
            'year' => '2017',
            'season' => 'Winter',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        //2018
        DB::table('seasons')->insert([
            'year' => '2018',
            'season' => 'Spring',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('seasons')->insert([
            'year' => '2018',
            'season' => 'Summer',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('seasons')->insert([
            'year' => '2018',
            'season' => 'Fall',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('seasons')->insert([
            'year' => '2018',
            'season' => 'Winter',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        //2019
        DB::table('seasons')->insert([
            'year' => '2019',
            'season' => 'Spring',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('seasons')->insert([
            'year' => '2019',
            'season' => 'Summer',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('seasons')->insert([
            'year' => '2019',
            'season' => 'Fall',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('seasons')->insert([
            'year' => '2019',
            'season' => 'Winter',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
