<?php

namespace Database\Factories;

use App\STLevel;
use App\STSeason;
use App\STShirtSize;
use App\STSwimmer;
use Illuminate\Database\Eloquent\Factories\Factory;

class STSwimmerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = STSwimmer::class;

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
            'birthDate' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'yesterday'),
            'parent' => $this->faker->name,
            'notes' => null,
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->postcode,
            'emergencyName' => $this->faker->firstNameFemale,
            'emergencyRelationship' => 'Mom',
            'emergencyPhone' => $this->faker->phoneNumber,
            's_t_level_id' => STLevel::factory(),
            's_t_season_id' => STSeason::factory(),
            's_t_shirt_size_id' => STShirtSize::factory(),
        ];
    }
}
