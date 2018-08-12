<?php

namespace App\Http\Controllers;

use App\Mail\STInvitation;
use App\PromoCode;
use App\STLevel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Tryout;
use App\Athlete;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AthleteController extends Controller
{
    /**
     * @param Athlete $athlete
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Athlete $athlete)
    {
        $levels = STLevel::all();
        $promoCodes = PromoCode::all();
        return view('athlete.show', compact('athlete', 'levels', 'promoCodes'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * @param Athlete $athlete
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Athlete $athlete)
    {
        return view('athlete.edit', compact('athlete'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function youMadeTheTeamEmail(Request $request)
    {
        $request->validate([
            'level_id' => 'required|integer',
            'athlete_id' => 'required|integer'
        ]);

        if($request['promo_id']){
            $promo = PromoCode::find($request['promo_id']);
        } else {
            $promo = null;
        }

        $athlete = Athlete::find($request->athlete_id);
        Log::info("Updating Athlete ID: $athlete->id and adding s_t_level of $request->level_id");
        $athlete->update(['s_t_level' => $request->level_id]);

        Log::info("Sending email to Athlete ID: $athlete->id, Email: $athlete->email a you made the team email for swim school level ID: $request->level_id");
        Mail::to($athlete->email)->send(new STInvitation($athlete, $promo));
        $athlete->update(['s_t_sign_up_email' => 1]);
        session()->flash('success', "Sent you made the team email to $athlete->firstName $athlete->lastName.");
        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $athlete = $request->validate([
            'firstName' => 'required|string|max:191',
            'lastName' => 'required|string|max:191',
            'birthDate' => 'required|string',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'required|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergencyName' => 'required|max:191',
            'emergencyRelationship' => 'required|max:191',
            'emergencyPhone' => 'required|max:20'
        ]);

        $athlete['birthDate'] = Carbon::parse($athlete['birthDate']);

        $oldAthlete = Athlete::find($id);
        $oldAthlete->update($athlete);
        Log::info("Athlete ID: $oldAthlete->id has been updated.");
        session()->flash('success', $oldAthlete->firstName.' '.$oldAthlete->lastName.' has been updated.');
        return redirect('/athlete/'.$oldAthlete->id);
    }

    /**
     * @param Athlete $athlete
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Athlete $athlete)
    {
        session()->flash('success', "$athlete->firstName $athlete->lastName has been deleted.");
        Log::info("Athlete ID: $athlete->id was deleted.");
        $athlete->delete();
        return redirect('/dashboard');
    }
}
