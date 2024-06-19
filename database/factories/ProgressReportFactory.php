<?php

namespace Database\Factories;

use App\ProgressReport;
use App\Skill;
use App\Swimmer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\ProgressReport
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class ProgressReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = ProgressReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'swimmer_id' => Swimmer::factory(),
            'skill_id' => Skill::factory(),
            'passed' => false,
        ];
    }
}
