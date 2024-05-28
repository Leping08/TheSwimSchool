<?php

namespace Database\Factories;

use App\Instructor;
use App\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\PoolSession>
 */
class PoolSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start' => $this->faker->dateTime(),
            'end' => $this->faker->dateTime(),
            'pool_session_id' => $this->faker->randomNumber(),
            'pool_session_type' => $this->faker->word(),
            'location_id' => Location::factory(),
            'instructor_id' => Instructor::factory(),
        ];
    }
}
