<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Swimmer;
use App\Lesson;
use App\Season;
use App\Location;
use App\Group;
use App\Contact;
use App\DaysOfTheWeek;
use Carbon\Carbon;
use App\Http\Controllers\GetSeason;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $swimmers = Swimmer::where('paid', '=', '1')->orderBy('created_at', 'desc')->limit(10)->get();
        $seasons = Season::all();
        //TODO: Add pagination to swimmer levels
        $groups = Group::all();
        $locations = Location::all();
        $daysOfTheWeek = DaysOfTheWeek::all();
        $lessons = Lesson::all();
        $leads = Contact::latest()->paginate(8, ['*'], 'leads');

        $todaysLessons = Lesson::whereHas('DaysOfTheWeek', function ($query) {
            $query->where([
                    ['days_of_the_weeks.id', '=', (Carbon::now()->subDay(1)->dayOfWeek + 1)], //TODO: Fix this day of the week to display today's lessons
                    ['class_start_date', '<=', Carbon::now()],
                    ['class_end_date', '>=',Carbon::now()]
                ]);
        })
        ->get();

        return view('pages.dashboard', compact('swimmers', 'todaysLessons', 'seasons', 'groups', 'locations', 'daysOfTheWeek', 'lessons', 'leads'));
    }

    public function swimmersForCurrentSeason()
    {
        $season = GetSeason::getCurrentSeason();
        return Swimmer::whereHas('lesson', function ($query) use ($season) {
            $query->where('season_id', '=', $season->id);
        })->get();
    }
}
