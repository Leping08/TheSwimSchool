<?php

namespace Tests\Feature;

use App\Lesson;
use App\Library\GroupLessonsReminderEmail;
use App\Mail\Groups\GroupLessonReminder;
use App\Swimmer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class GroupLessonReminderEmailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_send_emails_out_to_all_swimmers_in_lessons_starting_tomorrow()
    {
        Mail::fake();

        $lesson = Lesson::factory()->create([
            'class_start_date' => now()->addDay(),
        ]);
        $swimmer = Swimmer::factory()->create([
            'lesson_id' => $lesson->id,
        ]);

        GroupLessonsReminderEmail::sendReminderEmails();

        Mail::assertSent(GroupLessonReminder::class, function ($mail) use ($swimmer) {
            return $mail->hasTo($swimmer->email);
        });
    }

    #[Test]
    public function it_only_send_emails_out_to_all_swimmers_in_lessons_starting_tomorrow()
    {
        Mail::fake();

        $todayLesson = Lesson::factory()->create([
            'class_start_date' => now()->today(),
        ]);
        $todaySwimmer = Swimmer::factory()->create([
            'lesson_id' => $todayLesson->id,
        ]);

        $yesterdayLesson = Lesson::factory()->create([
            'class_start_date' => now()->yesterday(),
        ]);
        $yesterdaySwimmer = Swimmer::factory()->create([
            'lesson_id' => $yesterdayLesson->id,
        ]);

        GroupLessonsReminderEmail::sendReminderEmails();

        Mail::assertNotSent(GroupLessonReminder::class, function ($mail) use ($todaySwimmer) {
            return $mail->hasTo($todaySwimmer->email);
        });

        Mail::assertNotSent(GroupLessonReminder::class, function ($mail) use ($yesterdaySwimmer) {
            return $mail->hasTo($yesterdaySwimmer->email);
        });
    }
}
