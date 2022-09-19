<?php

namespace Database\Factories;

use App\PrivateLesson;
use App\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivateLessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrivateLesson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'season_id' => Season::factory(),
        ];
    }
}
