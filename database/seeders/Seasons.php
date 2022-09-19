<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
        $seasons = [
            'Spring',
            'Summer',
            'Fall',
            'Winter',
        ];

        $years = range(2017, 2025);

        foreach ($years as $year) {
            foreach ($seasons as $season) {
                \Illuminate\Support\Facades\DB::table('seasons')->insert([
                    'year' => $year,
                    'season' => $season,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
