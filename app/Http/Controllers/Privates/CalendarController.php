<?php

namespace App\Http\Controllers\Privates;

use App\Http\Controllers\Controller;
use App\Lesson;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function show()
    {
        $lessons = Lesson::registrationOpen()->with('group')->get();

        $events = collect();
        foreach ($lessons as $lesson) {
            $events->push($lesson->calendarEvents->map(function ($eventDate) use ($lesson) {
                $eventDate = Carbon::parse($eventDate);
                return [
                    'id' => $lesson->id,
                    'title' => $lesson->group->type,
                    'description' => 'This is the description',
                    'start' => Carbon::parse($eventDate->toDateString() . $lesson->class_start_time->toTimeString()),
                    'end' => Carbon::parse($eventDate->toDateString() . $lesson->class_end_time->toTimeString()),
                    'color' => $lesson->isFull() ? '#757575' : '#FF4870', //Gray is full and pink is not full
                    'lesson_id' => $lesson->id
                ];
            }));
        }

        $events = $events->flatten(1); //Do this to avoid them being grouped by the lesson



        return view('lessons.private.calendar', compact('events'));
    }
}
