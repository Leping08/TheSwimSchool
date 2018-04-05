<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Tryout;
use App\Athlete;
use Illuminate\Support\Facades\Log;

class AthleteController extends Controller
{
    public function show(Athlete $athlete)
    {
        //$athlete = Athlete::find($id);
        return view('athlete.show', compact('athlete'));
    }


    public function store(Request $request, $id)
    {
        $tryout = Tryout::find($id);

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

        $newAthlete = Athlete::create($athlete);

        Log::info("Athlete ID: $newAthlete->id signed up for Tryout ID: $tryout->id!");
        session()->flash('success', "Thanks for signing up! Don't forget to mark your calendar for the tryout.");
        return redirect("/swim-team");
    }
}
