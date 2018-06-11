<?php

namespace App\Http\Controllers;


use App\Swimmer;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SwimmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //check to see if any swimmers are singed up
        $swimmers = Swimmer::where('paid', '=', '1')->orderBy('id', 'desc')->get();
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
     * @param Request $request
     * @param $classType
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function store(Request $request, $classType, $id)
    {
        $lesson = Lesson::find($id);

        //Check to see if the lesson is full
        if($lesson->isLessonFull()){
            $request->session()->flash('danger', 'The lesson is full.');
            return back();
        }

        $swimmer = $request->validate([
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

        //TODO: Logic to check the age of the swimmer against what the lesson age is
        $swimmer['birthDate'] = Carbon::parse($swimmer['birthDate']);

        $newSwimmer = Swimmer::create($swimmer);

        Log::info("Swimmer ID: $newSwimmer->id signed up for Lesson ID: $lesson->id and is going to pay by card!");
        return view('swimmers.cardCheckout', compact('newSwimmer', 'lesson'));
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
        $swimmer = Swimmer::find($id);
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
        $swimmer = $request->validate([
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
            'emergencyPhone' => 'required|max:20',
            'lessonId' => 'required|integer'
        ]);

        $swimmer['birthDate'] = Carbon::parse($swimmer['birthDate']);

        try {
            $newLesson = Lesson::findOrFail($request->lessonId);
        }catch(\Exception $e){
            session()->flash('error', "We couldn't find that lesson.");
            Log::info("Trying to update swimmer ID: $id but could not find Lesson ID: $request->lessonId.");
            return back();
        }

        try {
            $oldSwimmer = Swimmer::findOrFail($id);
        }catch(\Exception $e){
            session()->flash('error', "We couldn't find that swimmer.");
            Log::info("Trying to update Swimmer but could not find Swimmer ID: $id.");
            return back();
        }

        try {
            $oldLesson = Lesson::findOrFail($oldSwimmer->lesson->id);
        }catch(\Exception $e){
            session()->flash('error', "The Swimmer ID: $oldSwimmer->id is not associated with a lesson so we couldn't update the Lesson ID.");
            Log::info("The Swimmer ID: $oldSwimmer->id is not associated with a lesson so we couldn't update the Lesson ID.");
            return back();
        }


        //Move swimmer to the new lesson
        if($oldSwimmer->lesson_id != $request->lessonId){
            $oldSwimmer->lesson_id = $request->lessonId;
            Log::info("Swimmer ID: $oldSwimmer->id was moved from Lesson ID $oldLesson->id to Lesson ID $newLesson->id.");
        }

        $oldSwimmer->update($swimmer);
        Log::info("Swimmer ID: $oldSwimmer->id has been updated.");
        session()->flash('success', $oldSwimmer->firstName.' '.$oldSwimmer->lastName.' has been updated.');
        return redirect('/swimmers/'.$oldSwimmer->id);
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $swimmer = Swimmer::find($id);
        session()->flash('success', $swimmer->firstName.' '. $swimmer->lastName .' has been deleted.');
        Log::info("Swimmer ID: $swimmer->id was deleted.");
        $swimmer->delete();
        return redirect('/swimmers');
    }
}
