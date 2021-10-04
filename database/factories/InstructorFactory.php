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
            'name' => $this->faker->firstName,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'image' => $this->faker->imageUrl(),
            'bio' => $this->faker->paragraph,
            'configuration' => []
        ];
    }
}
