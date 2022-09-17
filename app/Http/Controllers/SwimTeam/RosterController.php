<?php


namespace App\Http\Controllers\SwimTeam;


use App\Http\Controllers\Controller;
use App\STLevel;
use App\STSeason;
use Illuminate\View\View;

class RosterController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        $seasons = STSeason::orderBy('created_at', 'desc')->get();
        $levels = STLevel::with(['swimmers' => function ($query) {
            return $query->orderBy('lastName','ASC');
        }])->get();
        $currentSeason = STSeason::where('current_season', '=', true)->get();
        return view('swim-team.roster', compact('seasons', 'levels', 'currentSeason'));
    }
}