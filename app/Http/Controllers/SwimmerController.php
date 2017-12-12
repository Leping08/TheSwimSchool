<?php

namespace App\Http\Controllers;

use App\Jobs\SignupEmail;
use App\Swimmer;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\SignUp;
use Illuminate\Support\Facades\Mail;

class SwimmerController extends Controller
{
    public function __construct()
    {
        //
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check to see if any swimmers are singed up
        $swimmers = Swimmer::orderBy('id', 'desc')->get();
        return view('swimmers.list', compact('swimmers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //Sign a swimmer up for a lesson and send them to the card payment page or back to the lesson page.
    public function store(Request $request, $classType, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'age' => 'required|digits_between:1,3',
            'email' => 'required|string|email|max:191',
            'phone' => 'required|max:20',
            'parent' => 'nullable|max:191',
            'street' => 'required|max:191',
            'city' => 'required|max:191',
            'state' => 'required|max:191',
            'zip' => 'required|max:15',
            'emergencyName' => 'required|max:191',
            'emergencyRelationship' => 'required|max:191',
            'emergencyPhone' => 'required|max:20',
            'payment' => 'required'
        ]);

        $lesson = Lesson::find($id);

        $newSwimmer = Swimmer::create($request->all());
        $newSwimmer->update(['lesson_id' => $lesson->id]);

        Log::info("Swimmer ID: $newSwimmer->id was added to the DB.");

        //TODO: add signup email to the que
        Mail::to($newSwimmer->email)->send(new SignUp($lesson));
        Log::info("Group Lesson sign up email sent to $newSwimmer->email. Swimmer ID: $newSwimmer->id Lesson ID: $lesson->id.");
        //SignupEmail::dispatch($lesson, $newSwimmer->email);


        //If the user is using a card for payment, send them to the card view with the user id.
        if(request('payment') === 'card'){
            Log::info("Swimmer ID: $newSwimmer->id signed up for Lesson ID: $lesson->id and is going to pay by card!");
            return view('swimmers.cardCheckout', compact('newSwimmer', 'lesson'));
        }elseif(request('payment') === 'check'){
            Log::info("Swimmer ID: $newSwimmer->id signed up for Lesson ID: $lesson->id and is going to pay by cash or check!");
            $request->session()->flash('success', 'You are all signed up! First lesson is '.$lesson->class_start_date->toFormattedDateString().' at '.$lesson->class_start_time->format('H:i A').'. Be sure to bring cash or check for $'.$lesson->price.' to the first lesson.');
            return redirect('lessons/'.$lesson->class_type);
        }else{
            Log::warning("Something went wrong with Swimmer ID: $newSwimmer->id when they tried to sign up for Lesson ID: $lesson->id");
            $request->session()->flash('danger', 'Looks like something went wrong.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Swimmer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $swimmer = Swimmer::findOrFail($id);
        return view('swimmers.show', compact('swimmer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Swimmer  $swimmer
     * @return \Illuminate\Http\Response
     */
    public function edit(Swimmer $swimmer, $id)
    {
        $swimmer = Swimmer::findOrFail($id);
        return view('swimmers.edit', compact('swimmer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Swimmer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:191',
            'age' => 'required|digits_between:1,3',
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

        $swimmer = Swimmer::find($id);
        $swimmer->update($request->all());
        Log::info("Swimmer ID: $swimmer->id has been updated.");
        session()->flash('info', $swimmer->name.' has been updated.');
        return redirect('/swimmers/'.$swimmer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Swimmer  $swimmer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Swimmer $swimmer)
    {
        $swimmerToDelete = Swimmer::find($swimmer->id);
        session()->flash('success', $swimmerToDelete->name.' has been deleted.');
        Log::info("Swimmer ID: $swimmerToDelete->id was deleted.");
        $swimmerToDelete->delete();
        return redirect('/swimmers');
    }
}
