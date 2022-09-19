<?php

namespace Database\Factories;

use App\EmailList;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmailList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->email,
            'subscribe' => 1,
        ];
    }
}
