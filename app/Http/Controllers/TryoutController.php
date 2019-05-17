<?php

namespace App\Http\Controllers;

use App\Library\Helpers\SeasonHelpers;
use App\STSeason;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Tryout;
use App\Location;
use Illuminate\Support\Facades\Log;

class TryoutController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tryouts = Tryout::registrationOpen()->with('location')->get();
        return view('tryouts.index', compact('tryouts'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signUp($id)
    {
        $tryout = Tryout::with('location', 'athletes')->find($id);
        return view('tryouts.signup', compact('tryout'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $tryout = Tryout::with('location', 'athletes')->find($id);
        return view('tryouts.show', compact('tryout'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $tryout = $request->validate([
            'class_size' => 'required|digits_between:1,3',
            'location_id' => 'required|digits_between:1,3',
            'registration_open' => 'required|date',
            'event_time' => 'required|date'
        ]);

        $tryout['s_t_season_id'] = STSeason::GetCurrentSeason()->id;
        $tryout['registration_open'] = Carbon::parse($tryout['registration_open']);
        $tryout['event_time'] = Carbon::parse($tryout['event_time']);

        $newTryout = Tryout::create($tryout);
        Log::info("Tryout ID: $newTryout->id has been created.");
        session()->flash('success', "Tryout was created!");
        return back();
    }
}
