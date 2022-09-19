<?php

namespace Database\Factories;

use App\STSeason;
use Illuminate\Database\Eloquent\Factories\Factory;

class STSeasonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = STSeason::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'dates' => $this->faker->word,
            'current_season' => true,
        ];
    }
}
