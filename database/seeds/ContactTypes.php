<?php

use Illuminate\Database\Seeder;

class ContactTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_types')->insert([
            'name' => 'Contact Us',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('contact_types')->insert([
            'name' => 'Request A Lifeguard',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('contact_types')->insert([
            'name' => 'CPR and First Aid Training',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        DB::table('contact_types')->insert([
            'name' => 'Request Private Lessons',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
