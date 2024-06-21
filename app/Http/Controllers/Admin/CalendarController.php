<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Instructor;
use App\PoolSession;
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
        $events = $this->calendarEvents($instructor);

        return view('admin.calendar.show', compact('events', 'instructor'));
    }

    /**
     * @param  Instructor  $instructor
     * @return array
     */
    public function calendarEvents(Instructor $instructor)
    {
        $events = collect();

        //Get all private pool sessions from 3 months ago and up
        $groupPoolSessions = PoolSession::where('instructor_id', $instructor->id)
            ->groupLessons()
            ->whereDate('start', '>=', Carbon::now()->subMonths(3))
            ->with(['lesson.swimmers.attendances', 'lesson.group', 'lesson.waitList', 'location', 'attendances'])
            ->get();

        // Map the group lesson into a calendar event
        $events->push($groupPoolSessions->map(function ($session) {
            $swimmers = $session->lesson->swimmers;

            return [
                'id' => $session->id,
                'lesson_id' => $session->lesson->id,
                'title' => $session->lesson->group->type,
                'start' => $session->start,
                'end' => $session->end,
                'color' => count($swimmers) ? self::COLORS['group'] : self::COLORS['empty'],
                'details_link' => '/admin/resources/lessons/'.$session->lesson->id,
                'swimmers' => $session->lesson->swimmers,
                'location' => $session->location->name,
                'attendances' => $session->attendances,
                'waitList' => $session->lesson->waitList,
            ];
        }));

        //Get all private pool sessions from 3 months ago and up
        $privatePoolSessions = PoolSession::where('instructor_id', $instructor->id)
            ->privateLessons()
            ->whereDate('start', '>=', Carbon::now()->subMonths(3))
            ->with(['lesson.swimmer.attendances', 'location', 'attendances'])
            ->get();

        //Map the Private Lessons into calendar events
        $events->push($privatePoolSessions->map(function ($session) {
            $swimmer = $session?->lesson?->swimmer;
            $detailsLink = $swimmer ?
                '/admin/resources/private-lessons/'.$session?->lesson?->id :
                '/admin/resources/pool-sessions/'.$session->id;

            return [
                'id' => $session->id,
                'title' => 'Private',
                'start' => $session->start,
                'end' => $session->end,
                'color' => $swimmer ? self::COLORS['private'] : self::COLORS['empty'],
                'details_link' => $detailsLink,
                'swimmers' => $swimmer ? [$swimmer] : [],
                'location' => $session->location->name,
                'attendances' => $session->attendances,
                'waitList' => [],
            ];
        }));

        // Flatten the group lessons and the private lessons into one pool session collection
        return $events->flatten(1);
    }
}
