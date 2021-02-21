<?php

namespace Database\Factories;

use App\PrivateLesson;
use App\PrivateSwimmer;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrivateSwimmerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PrivateSwimmer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birth_date' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'yesterday'),
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'parent' => $this->faker->name,
            'notes' => $this->faker->paragraph,
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->postcode,
            'emergency_name' => $this->faker->firstNameFemale,
            'emergency_relationship' => 'Mom',
            'emergency_phone' => $this->faker->phoneNumber,
            'stripe_charge_id' => 'ch_' . $this->faker->bothify('##??##??##??##??##??##??##??##??'),
            'private_lesson_id' => PrivateLesson::factory()
        ];
    }
}