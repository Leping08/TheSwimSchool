<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Lesson;
use App\PrivatePoolSession;
use App\User;
use Carbon\Carbon;

class CalendarController extends Controller
{
    const COLORS = [
        'private' => '#4299e1',
        'group' => '#ed64a6',
        'empty' => '#a0aec0'
    ];

    public function show(User $user)
    {
        $events = $this->calendarEvents($user);

        return view('admin.calendar.show', compact('events', 'user'));
    }

    /**
     * @param  User  $user
     * @return array
     */
    public function calendarEvents(User $user)
    {
        $events = collect();

        //Get all the lessons from 3 months ago and up
        $lessons = Lesson::whereDate('class_start_date', '>=', Carbon::now()->subMonths(3))
                            ->where('instructor_id', $user->id)
                            ->with(['group', 'swimmers', 'location'])
                            ->get();

        //Loop over the group lessons and generate pool sessions for them
        foreach ($lessons as $lesson) {
            $events->push($lesson->calendarEvents->map(function ($eventDate) use ($lesson) {
                $eventDate = Carbon::parse($eventDate);
                return [
                    'id' => $lesson->id,
                    'title' => $lesson->group->type,
                    'start' => Carbon::parse($eventDate->toDateString().$lesson->class_start_time->toTimeString()),
                    'end' => Carbon::parse($eventDate->toDateString().$lesson->class_end_time->toTimeString()),
                    'color' => $lesson->swimmers->count() ? self::COLORS['group'] : self::COLORS['empty'],
                    'details_link' => '/admin/resources/lessons/'.$lesson->id,
                    'swimmers' => $lesson->swimmers,
                    'location' => $lesson->location->name
                ];
            }));
        }

        //Get all private pool sessions from 3 months ago and up
        $poolSessions = PrivatePoolSession::where('instructor_id', $user->id)
                            ->whereDate('start', '>=', Carbon::now()->subMonths(3))
                            ->with(['swimmers', 'location'])
                            ->get();

        //Map the Private Lessons into calendar events
        $events->push($poolSessions->map(function ($session) {
            return [
                'id' => $session->id,
                'title' => 'Private',
                'start' => $session->start,
                'end' => $session->end,
                'color' => $session->swimmers->count() ? self::COLORS['private'] : self::COLORS['empty'],
                'details_link' => '/admin/resources/private-pool-sessions/'.$session->id,
                'swimmers' => $session->swimmers,
                'location' => $session->location->name
            ];
        }));

        //Do this to avoid them being grouped by the lesson
        return $events->flatten(1);
    }
}