<?php

namespace Database\Factories;

use App\Athlete;
use App\Tryout;
use App\STSeason;
use Illuminate\Database\Eloquent\Factories\Factory;

class AthleteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Athlete::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'hash' => $this->faker->lexify('??????????'),
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'birthDate' => $this->faker->dateTimeBetween($startDate = '-30 years', $endDate = 'yesterday'),
            'tryout_id' => Tryout::factory(),
            'parent' => $this->faker->name,
            'notes' => $this->faker->paragraph,
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'state' => $this->faker->word,
            'zip' => $this->faker->postcode,
            'emergencyName' => $this->faker->firstNameFemale,
            'emergencyRelationship' => 'Mom',
            'emergencyPhone' => $this->faker->phoneNumber,
            's_t_season_id' => STSeason::factory(),
            's_t_sign_up_email' => false
        ];
    }
}
