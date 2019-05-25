<?php

namespace Tests\Feature;

use App\FeedbackSurvey;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeedbackTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function a_user_can_fill_out_the_feedback_survey()
    {
        $this->get("/feedback")
            ->assertStatus(200)
            ->assertSee('Feedback');

        $data = [
            'question_1' => 4,
            'question_2' => 4,
            'question_3' => 4,
            'question_4' => 4,
            'question_5' => 5,
            'question_6' => 4,
            'question_7' => 4,
            'question_8' => 4,
            'question_9' => 1,
            'question_10' => 4,
            'question_11' => 4,
            'question_12' => 4,
            'question_13' => 4,
            'question_14' => 4,
            'question_15' => $this->faker->sentence(),
            'question_16' => $this->faker->sentence(),
            'question_17' => $this->faker->sentence(),
            'question_18' => $this->faker->sentence(),
        ];

        $this->assertEquals(0, FeedbackSurvey::all()->count());

        $this->post('/feedback', $data)
            ->assertStatus(302)
            ->assertRedirect('/thank-you');

        $this->assertEquals(1, FeedbackSurvey::all()->count());

        $feedback = FeedbackSurvey::with('answers.question')->get();

        $this->assertEquals(4, $feedback[0]->answers[0]->answer);
        $this->assertEquals(1, $feedback[0]->answers[8]->answer);
    }
}
