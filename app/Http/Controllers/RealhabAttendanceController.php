<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\PoolSession;
use App\PrivateLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RealhabAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $startDate = Carbon::parse($request->get('start'));
        $endDate = Carbon::parse($request->get('end'));

        $poolSessionTypes = collect([
            'group' => Lesson::class,
            'private' => PrivateLesson::class,
        ]);

        $poolSessionType = $poolSessionTypes->get($request->get('type'));

        // Get all the swimmers that attended a pool_session with the location id 63
        $sessions = PoolSession::where('location_id', 63)
            ->where('start', '>=', $startDate)
            ->where('end', '<=', $endDate)
            ->where('pool_session_type', $poolSessionType)
            ->with(['attendances' => function ($query) {
                // Attendances where attended is true
                $query->where('attended', true);
            }, 'attendances.swimmable'])
            ->get();

        // Filter out any pool sessions where the no swimmer has attended.
        // This is to avoid empty pool sessions
        $sessions = $sessions->filter(function ($session) {
            return collect(data_get($session, 'attendances.*.swimmer'))->filter()->flatten()->isNotEmpty();
        });

        // Filter out any attendances that dont have a swimmer
        $sessions = $sessions->map(function ($session) {
            $session->filtered_attendances = collect(data_get($session, 'attendances'))->filter(function ($attendance) {
                return !empty($attendance->swimmer);
            });
            return $session;
        });

        // Get the swimmers only
        $swimmers = collect(data_get($sessions, '*.attendances.*.swimmer'))->filter()->flatten();

        return view('lessons.realhab-attendance', compact(['sessions', 'swimmers']));
    }
}
