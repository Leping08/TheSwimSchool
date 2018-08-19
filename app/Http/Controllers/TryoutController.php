<?php

namespace App\Http\Controllers;

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
        $tryouts = Tryout::whereDate('event_time', '>=', Carbon::now())
                            ->whereDate('registration_open', '<=', Carbon::now())
                            ->with('location', 'athletes')
                            ->get();
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $locations = Location::all();
        $tryout = Tryout::with('location', 'athletes')->find($id);
        return view('tryouts.edit', compact('tryout', 'locations'));
    }

    /**
     * @param Request $request
     * @param Tryout $tryout
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Tryout $tryout)
    {
        $newTryout = $request->validate([
            'class_size' => 'required|digits_between:1,3',
            'location_id' => 'required|digits_between:1,3',
            'registration_open' => 'required|date',
            'event_time' => 'required|date'
        ]);

        $newTryout['season_id'] =  GetSeason::getSeasonFromDate($newTryout['event_time'])->id;
        $newTryout['registration_open'] = Carbon::parse($newTryout['registration_open']);
        $newTryout['event_time'] = Carbon::parse($newTryout['event_time']);

        $tryout->update($newTryout);
        Log::info("Tryout ID: $tryout->id has been updated.");
        session()->flash('success', "Tryout ID: $tryout->id has been updated.");
        return redirect('/tryouts/'.$tryout->id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $tryout = Tryout::with('location', 'athletes')->find($id);
        if($tryout->athletes->count() > 0){
            Log::info("Tryout ID: $tryout->id can not be deleted. It has athletes associated with it.");
            session()->flash('warning', "Tryout ID: $tryout->id can not be deleted. It has athletes associated with it.");
            return back();
        }else{
            $tryout->delete();
            Log::info("Tryout ID: $tryout->id was deleted.");
            session()->flash('success', "Tryout ID: $tryout->id was deleted.");
            return redirect('/dashboard');
        }
    }
}
