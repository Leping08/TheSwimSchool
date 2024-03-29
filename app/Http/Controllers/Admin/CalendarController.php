<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Instructor;
use App\Lesson;
use App\PrivatePoolSession;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    const COLORS = [
        'private' => '#4299e1',
        'group' => '#ed64a6',
        'empty' => '#a0aec0',
    ];

    public function show(Request $request, Instructor $instructor)
    {
        $events = $this->calendarEvents($instructor, $request->input('start_date') ?? null);

        return view('admin.calendar.show', compact('events', 'instructor'));
    }

    /**
     * @param  Instructor  $instructor
     * @param  string  $startDate
     * @return array
     */
    public function calendarEvents(Instructor $instructor, $startDate = null)
    {
        $events = collect();
        // Get the start date if its passed though as a query param
        // If not, use the current date sub 3 months
        $requestStartDate = $startDate ? Carbon::parse($startDate) : Carbon::now()->subMonths(3);

        //Get all the lessons from 3 months ago and up
        $lessons = Lesson::whereDate('class_end_date', '>=', $requestStartDate)
                            ->where('instructor_id', $instructor->id)
                            ->with(['group', 'swimmers', 'location', 'waitList', 'daysOfTheWeek'])
                            ->withCount(['swimmers'])
                            ->get();

        //Loop over the group lessons and generate pool sessions for them
        // todo refactor calendarEvents method to not be as heavy on the DB
        foreach ($lessons as $lesson) {
            $events->push($lesson->calendarEvents->map(function ($eventDate) use ($lesson) {
                $eventDate = Carbon::parse($eventDate);

                return [
                    'id' => $lesson->id,
                    'title' => $lesson->group->type,
                    'start' => Carbon::parse($eventDate->toDateString().$lesson->class_start_time->toTimeString()),
                    'end' => Carbon::parse($eventDate->toDateString().$lesson->class_end_time->toTimeString()),
                    'color' => $lesson->swimmers_count ? self::COLORS['group'] : self::COLORS['empty'],
                    'details_link' => '/admin/resources/lessons/'.$lesson->id,
                    'swimmers' => $lesson->swimmers,
                    'location' => $lesson->location->name,
                    'waitList' => $lesson->waitList,
                ];
            }));
        }

        //Get all private pool sessions from 3 months ago and up
        $poolSessions = PrivatePoolSession::where('instructor_id', $instructor->id)
                            ->whereDate('start', '>=', Carbon::now()->subMonths(3))
                            ->with(['location'])
                            ->get();

        //Map the Private Lessons into calendar events
        $events->push($poolSessions->map(function ($session) {
            $swimmer = $session->swimmer();

            return [
                'id' => $session->id,
                'title' => 'Private',
                'start' => $session->start,
                'end' => $session->end,
                'color' => $swimmer ? self::COLORS['private'] : self::COLORS['empty'],
                'details_link' => '/admin/resources/private-pool-sessions/'.$session->id,
                'swimmers' => [$swimmer],
                'location' => $session->location->name,
                'waitList' => [],
            ];
        }));

        //Do this to avoid them being grouped by the lesson
        return $events->flatten(1);
    }
}
