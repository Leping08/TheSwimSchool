<?php

namespace Database\Factories;

use App\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->lastName,
            'ages' => '6 years old',
            'next_level_id' => null,
            'icon' => $this->faker->word,
            'description' => $this->faker->paragraph,
        ];
    }
}
