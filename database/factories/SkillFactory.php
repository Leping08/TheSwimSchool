<?php

namespace Database\Factories;

use App\Group;
use App\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\Skill
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class SkillFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Skill::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => Group::factory(),
            'description' => $this->faker->sentence,
        ];
    }
}
