<?php

namespace Database\Factories;

use App\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Instructor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'bio' => $this->faker->sentence,
            'hex_color' => $this->faker->hexColor,
            'image_url' => $this->faker->imageUrl,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
