<?php

namespace Database\Factories;

use App\Location;
use App\STSeason;
use App\Tryout;
use Illuminate\Database\Eloquent\Factories\Factory;

class TryoutFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tryout::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            's_t_season_id' => STSeason::factory(),
            'location_id' => Location::factory(),
            'registration_open' => $this->faker->dateTimeBetween('-1 month', 'yesterday'),
            'event_time' => $this->faker->dateTimeBetween('tomorrow', '+1 week'),
        ];
    }
}
