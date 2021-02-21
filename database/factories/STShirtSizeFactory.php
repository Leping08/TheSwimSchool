<?php

namespace Database\Factories;

use App\STShirtSize;
use Illuminate\Database\Eloquent\Factories\Factory;

class STShirtSizeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = STShirtSize::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'size' => $this->faker->word,
        ];
    }
}
