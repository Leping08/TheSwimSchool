<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContactTypes::class);
        $this->call(DaysOfTheWeek::class);
        $this->call(Seasons::class);
    }
}
