<?php

namespace Database\Factories;

use App\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'active' => true,
            'created_time' => $this->faker->unique()->randomDigit,
            'message' => $this->faker->sentence,
        ];
    }
}
