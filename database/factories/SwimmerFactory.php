<?php

namespace Database\Factories;

use App\Lesson;
use App\Swimmer;
use Illuminate\Database\Eloquent\Factories\Factory;

class SwimmerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Swimmer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'paid' => $this->faker->boolean,
            'birthDate' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'yesterday'),
            'lesson_id' => Lesson::factory(),
            'parent' => $this->faker->name,
            'notes' => $this->faker->paragraph,
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->postcode,
            'emergencyName' => $this->faker->firstNameFemale,
            'emergencyRelationship' => 'Mom',
            'emergencyPhone' => $this->faker->phoneNumber,
        ];
    }
}
