<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Swimmer;
use App\Http\Controllers\GetSeason;

class DashboardController extends Controller
{
    public function index()
    {
        $swimmers = Swimmer::orderBy('created_at', 'desc')->limit(10)->get();
        $todaysLessons = Lesson::where('days', '=', Carbon::now()->day);
        return view('pages.dashboard', compact('swimmers'));
    }

    public function swimmersForCurrentSeason()
    {
        $season = GetSeason::getCurrentSeason();
        return Swimmer::whereHas('lesson', function ($query) use ($season) {
            $query->where('season_id', '=', $season->id);
        })->get();
    }
}
