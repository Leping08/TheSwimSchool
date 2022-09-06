<?php

namespace App\Http\Controllers\SwimTeam;

use App\Http\Controllers\Controller;
use App\STSeason;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Tryout;
use App\Athlete;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class AthleteController extends Controller
{
    /**
     * @param Request $request
     * @param Tryout $tryout
     * @return Redirect
     */
    public function store(Request $request, Tryout $tryout)
    {
        //Check to see if the lesson is full
        if($tryout->isFull()){
            $request->session()->flash('danger', 'The tryout is full.');
            return back();
        }

        $athlete = $request->validate([
            'firstName' => 'required|string|max:191',
            'lastName' => 'required|string|max:191',
            'birthDate' => 'required|date|before:today',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'nullable|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergencyName' => 'required|max:191',
            'emergencyRelationship' => 'required|max:191',
            'emergencyPhone' => 'required|max:20'
        ]);

        $athlete['birthDate'] = Carbon::parse($athlete['birthDate']);
        $athlete['tryout_id'] = $tryout->id;

        $athlete['s_t_season_id'] = STSeason::currentseason()->id;

        $newAthlete = Athlete::create($athlete);

        Log::info("Athlete ID: $newAthlete->id signed up for Tryout ID: $tryout->id!");
        session()->flash('success', "Thanks for signing up! Don't forget to mark your calendar for the tryout.");
        return redirect("/swim-team");
    }

    public function update(Request $request)
    {
        // find the athlete by the hash
        $athlete = Athlete::findByHash($request->hash)->first() ?? null;

        if($athlete === null){
            return response()->json([
                'message' => 'Athlete not found'
            ], 404);
        }

        // filter down only values that have changed
        $athlete->update($request->only([
            'firstName',
            'lastName',
            'birthDate',
            'email',
            'phone',
            'parent',
            'street',
            'city',
            'state',
            'zip',
            'emergencyName',
            'emergencyRelationship',
            'emergencyPhone'
        ]));

        // return the athlete
        return response()->json($athlete);
    }

    /**
     * @param Request $request
     * @param Tryout $tryout
     * @return Redirect
     */
    public function new(Request $request, Tryout $tryout)
    {
        $athlete = $request->validate([
            'firstName' => 'required|string|max:191',
            'lastName' => 'required|string|max:191',
            'birthDate' => 'required|date|before:today',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'nullable|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergencyName' => 'required|max:191',
            'emergencyRelationship' => 'required|max:191',
            'emergencyPhone' => 'required|max:20'
        ]);

        $athlete['birthDate'] = Carbon::parse($athlete['birthDate']);
        $athlete['tryout_id'] = $tryout->id;

        $athlete['s_t_season_id'] = STSeason::currentseason()->id;

        $newAthlete = Athlete::create($athlete);

        Log::info("Athlete ID: $newAthlete->id signed up for Tryout ID: $tryout->id!");
        return $newAthlete;
    }
}
