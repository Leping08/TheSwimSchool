<?php

namespace Database\Factories;

use App\STCoach;
use Illuminate\Database\Eloquent\Factories\Factory;

class STCoachFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = STCoach::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => '9998887777',
            'active' => true,
            'bio' => $this->faker->paragraph
        ];
    }
}
