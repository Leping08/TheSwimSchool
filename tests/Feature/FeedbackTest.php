<?php

namespace Tests\Feature;

use App\FeedbackSurvey;
use App\Jobs\SendFeedbackEmails;
use App\Lesson;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_can_fill_out_the_feedback_survey()
    {
        $this->get(route('feedback.index'))
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

        $this->post(route('feedback.store'), $data)
            ->assertStatus(302)
            ->assertRedirect('/thank-you');

        $this->assertEquals(1, FeedbackSurvey::all()->count());

        $feedback = FeedbackSurvey::with('answers.question')->get();

        $this->assertEquals(4, $feedback[0]->answers[0]->answer);
        $this->assertEquals(1, $feedback[0]->answers[8]->answer);
    }

    /** @test */
    public function a_user_will_be_sent_a_feedback_email_a_week_after_the_lesson()
    {
        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::now()->subDays(14),
            'class_end_date' => Carbon::now()->subDays(7),
        ]);

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        $this->assertCount(1, Swimmer::all());

        $this->assertCount(1, Lesson::endedOneWeekAgo()->get());

        Mail::fake();
        Mail::assertNothingSent();

        SendFeedbackEmails::dispatchSync();

        Mail::assertSent(\App\Mail\Admin\FeedbackSurvey::class);
    }

    /** @test */
    public function a_user_will_only_receive_one_feedback_survey_if_they_sign_up_multiple_swimmers_with_the_same_email()
    {
        $email = 'test@gmail.com';

        $lesson = Lesson::factory()->create([
            'class_start_date' => Carbon::now()->subDays(14),
            'class_end_date' => Carbon::now()->subDays(7),
            'class_size' => 3,
        ]);

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
            'email' => $email,
        ]);

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
            'email' => $email,
        ]);

        Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
            'email' => $email,
        ]);

        $this->assertCount(3, Swimmer::all());

        $this->assertCount(1, Lesson::endedOneWeekAgo()->get());

        Mail::fake();
        Mail::assertNothingSent();

        SendFeedbackEmails::dispatchSync();

        Mail::assertSent(\App\Mail\Admin\FeedbackSurvey::class, 1);
    }
}
