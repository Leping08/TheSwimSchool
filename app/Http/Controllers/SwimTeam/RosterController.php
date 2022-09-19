<?php

namespace App\Http\Controllers\SwimTeam;

use App\Http\Controllers\Controller;
use App\STLevel;
use App\STSeason;
use App\STSwimmer;
use Illuminate\View\View;

class RosterController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $seasons = STSeason::orderBy('created_at', 'desc')->get();
        $swimmers = STSwimmer::orderBy('lastName', 'asc')->get();
        $levels = STLevel::all();
        $currentSeason = STSeason::where('current_season', '=', true)->get();

        return view('swim-team.roster', compact('seasons', 'levels', 'currentSeason', 'swimmers'));
    }
}
