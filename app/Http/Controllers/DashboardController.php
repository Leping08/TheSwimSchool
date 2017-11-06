<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Swimmer;
use App\Lesson;
use App\Season;
use App\Location;
use App\Group;
use App\DaysOfTheWeek;
use Carbon\Carbon;
use App\Http\Controllers\GetSeason;

class DashboardController extends Controller
{
    public function index()
    {
        $swimmers = Swimmer::orderBy('created_at', 'desc')->limit(10)->get();
        $seasons = Season::all();
        $groups = Group::all();
        $locations = Location::all();
        $daysOfTheWeek = DaysOfTheWeek::all();

        $todaysLessons = Lesson::whereHas('DaysOfTheWeek', function ($query) {
            $query->where('days_of_the_weeks.id', '=', Carbon::now()->dayOfWeek + 1);
        })
        ->where('class_start_date', '<=', Carbon::now())
        ->where('class_end_date', '>=', Carbon::now())
        ->get();

        return view('pages.dashboard', compact('swimmers', 'todaysLessons', 'seasons', 'groups', 'locations', 'daysOfTheWeek'));
    }

    public function swimmersForCurrentSeason()
    {
        $season = GetSeason::getCurrentSeason();
        return Swimmer::whereHas('lesson', function ($query) use ($season) {
            $query->where('season_id', '=', $season->id);
        })->get();
    }
}
