<?php

namespace Database\Factories;

use App\PoolSession;
use App\PoolSessionAttendance;
use App\Swimmer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\PoolSessionAttendance
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
class PoolSessionAttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = PoolSessionAttendance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attended' => false,
            'pool_session_id' => PoolSession::factory(),
            'swimmable_id' => Swimmer::factory(),
            'swimmable_type' => Swimmer::class,
        ];
    }
}
