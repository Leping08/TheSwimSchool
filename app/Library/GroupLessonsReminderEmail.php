<?php

namespace App\Library;

use App\Lesson;
use App\Mail\Groups\GroupLessonReminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class GroupLessonsReminderEmail
{
    public static function sendReminderEmails()
    {
        $lessons = Lesson::startingTomorrow()->with('Swimmers', 'Group', 'Location', 'DaysOfTheWeek')->get();
        if (count($lessons)) {
            foreach ($lessons as $lesson) {
                foreach ($lesson->swimmers as $swimmer) {
                    if ($swimmer->email) {
                        try {
                            Log::info("Sending group lesson reminder email to $swimmer->email for lesson ID: $lesson->id");
                            Mail::to($swimmer->email)->send(new GroupLessonReminder($lesson));
                        } catch (\Exception $e) {
                            Log::warning("Email error: $e");
                        }
                    }
                }
            }
        } else {
            Log::info('No lessons start tomorrow.');
        }
    }
}
