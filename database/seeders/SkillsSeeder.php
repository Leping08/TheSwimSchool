<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'group_name' => 'Parent & Infant/Toddler Beginner',
                'group_id' => 1,
                'skills' => [
                    'Is happy in the water',
                    'Jumps into water to parent and submerges, assisted',
                    'Enters into activities enthusiastically',
                    'Monkey crawls along wall to safe area, unsupported',
                    'Blows bubbles on the surface of water',
                    'Climbs out of pool independently',
                    'Kicks on front, assisted',
                    'Back float for 10 seconds, assisted',
                    'Paddles on front, assisted',
                    'Passes from parent to instructor',
                    'Retrieves objects on surface of water',
                    'Submerges under water with support willingly',
                    'Kicks on back, assisted',
                    'Submerges under water voluntarily/holds breath'
                ]
            ],
            [
                'group_name' => 'Parent & Toddler Advanced',
                'group_id' => 2,
                'skills' => [
                    'Submerges under water voluntarily & holds breath',
                    'Back float calmly for 10 seconds, assisted',
                    'Completely comfortable under water',
                    'Kicks on back, assisted',
                    'Monkey crawls along wall safely, unsupported',
                    'Swims from parent to instructor',
                    'Kicks & paddles on front w/ face in water holding breath unassisted to wall',
                    'Jumps into water & returns to wall unassisted',
                    'Climbs out of pool independently'
                ]
            ],
            [
                'group_name' => 'Shrimp',
                'group_id' => 3,
                'skills' => [
                    'Is happy in the water',
                    'Kicks and paddles on front, unassisted to wall',
                    'Enters into activities enthusiastically',
                    'Jumps into water and returns to wall, unassisted',
                    'Blows bubbles on the surface of water',
                    'Climbs out of pool independently',
                    'Retrieves objects under the water',
                    'Monkey crawls along wall unassisted to safe area',
                    'Submerges under water voluntarily/holds breath',
                    'Swims front stroke with face in water, assisted',
                    'Underwater exploration',
                    'Back float for 10 seconds, assisted',
                    'Completely comfortable under water',
                    'Kicks on back, assisted'
                ]
            ],
            [
                'group_name' => 'Seahourse',
                'group_id' => 4,
                'skills' => [
                    'Retrieves objects on pool floor, assisted',
                    'Jumps into water and returns to wall, unassisted',
                    'Basic front stroke, unassisted',
                    'Uses big arm over water recovery consistently while swimming',
                    'Back float for 20 seconds, unassisted',
                    'Takes regular breaths independently while swimming',
                    'Basic back stroke, unassisted',
                    'Swim Float Swim'
                ]
            ],
            [
                'group_name' => 'Starfish',
                'group_id' => 5,
                'skills' => [
                    'Retrieves objects on pool floor, unassisted',
                    'Basic backstroke',
                    'Swim Float Swim',
                    'Basic butterfly movement',
                    'Basic front stroke, taking regular breaths',
                    'Basic breaststroke movement'
                ]
            ],
            [
                'group_name' => 'Stingray',
                'group_id' => 6,
                'skills' => [
                    'Submerges under water voluntarily & holds breath',
                    'Jumps into water & returns to wall unassisted',
                    'Retrieves objects under the water',
                    'Completely comfortable under water',
                    'Back float for 20 seconds, unassisted',
                    'Basic front stroke unassisted w/ face in water',
                    'Basic back stroke, unassisted w/ proper holding breath & catching breaths independently arm rhythm as needed',
                    'Swim Float Swim Independently'
                ]
            ],
            [
                'group_name' => 'Dolphin',
                'group_id' => 7,
                'skills' => [
                    'Swims backstroke',
                    'Kicks full length of pool on front & back',
                    'Swims basic butterfly stroke',
                    'Uses swim float swim full length of pool as safety',
                    'Swims basic breaststroke stroke',
                    'Swims Individual Medley (width of pool)',
                    'Swims full length of pool freestyle stroke, taking regular breaths as needed'
                ]
            ],
            [
                'group_name' => 'Flying Fish',
                'group_id' => 8,
                'skills' => [
                    'Swims 25 yards freestyle using side breathing',
                    'Swims 25 yards breaststroke',
                    'Swims 25 yards backstroke',
                    'Swims Individual Medley (length of pool)',
                    'Swims 25 yards butterfly'
                ]
            ]
        ];

        // Check to see if records already exist in the skills table
        $skills = DB::table('skills')->get();
        if ($skills->count() > 0) {
            // Truncate the skills table if you want to reseed the data
            throw new \Exception('Skills already exist in the database.');
        }

        foreach ($groups as $group) {
            foreach ($group['skills'] as $skill) {
                DB::table('skills')->insert([
                    'group_id' => $group['group_id'],
                    'description' => $skill,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }
    }
}
