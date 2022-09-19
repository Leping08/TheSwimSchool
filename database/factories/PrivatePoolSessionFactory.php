<?php

namespace Database\Factories;

use App\Location;
use App\PrivateLesson;
use App\PrivatePoolSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivatePoolSessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrivatePoolSession::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'start' => Carbon::now(),
            'end' => Carbon::now()->addHour(),
            'private_lesson_id' => PrivateLesson::factory(),
            'location_id' => Location::factory(),
        ];
    }
}
