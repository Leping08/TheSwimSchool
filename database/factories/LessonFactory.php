<?php

namespace Database\Factories;

use App\Group;
use App\Instructor;
use App\Lesson;
use App\Location;
use App\Season;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lesson::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'season_id' => Season::factory(),
            'group_id' => Group::factory(),
            'location_id' => Location::factory(),
            'instructor_id' => Instructor::factory(),
            'price' => $this->faker->numberBetween(1, 150),
            'class_start_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'class_end_date' => $this->faker->dateTimeBetween('now', '+10 months'),
            'registration_open' => $this->faker->dateTimeBetween('-1 month', 'yesterday'),
            'class_start_time' => $this->faker->dateTime(),
            'class_end_time' => $this->faker->dateTimeAd('+1 hour')
        ];
    }
}