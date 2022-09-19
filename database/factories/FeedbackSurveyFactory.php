<?php

namespace Database\Factories;

use App\FeedbackSurvey;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackSurveyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FeedbackSurvey::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'viewed' => false,
        ];
    }
}
