<?php

namespace App\Http\Controllers;


use App\EmailList;
use App\Library\Stripe;
use App\Library\StripeCharge;
use App\Mail\ClassFull;
use App\Mail\SignUp;
use App\Swimmer;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function store(Request $request)
    {
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
            'emergencyPhone' => 'required|max:20',
            'lesson_id' => 'required',
            'stripeToken' => 'required'
        ]);

        $lesson = Lesson::find($request->lesson_id);

        //Check to see if the lesson is full
        if($lesson->isLessonFull()){
            $request->session()->flash('danger', 'The lesson is full.');
            return back();
        }

        //TODO: Logic to check the age of the swimmer against what the lesson age is
        $swimmer['birthDate'] = Carbon::parse($swimmer['birthDate']);

        $newSwimmer = Swimmer::create($swimmer);

        if($request->emailUpdates === 'on'){
            EmailList::firstOrCreate(['email' => $request->email]);
            Log::info("Adding $request->email to EmailListTest.");
        } else {
            Log::info("$request->email does not want to receive marketing emails.");
        }

        //TODO: Add logic for promo code

        Log::info("Swimmer ID: $newSwimmer->id signed up for Lesson ID: $lesson->id and is going to pay by card!");
        try {
            $stripeCharge = (new StripeCharge())->pay($request->stripeToken, $lesson->price, $newSwimmer->email, $lesson->group->type . " swim lessons for $newSwimmer->firstName $newSwimmer->lastName through The Swim School.");
            $newSwimmer->stripeChargeId = $stripeCharge->id;
            $newSwimmer->paid = 1;
            $newSwimmer->save();
        } catch (\Exception $e) {
            Log::error('Something went wrong with the payment sending the user back to the checkout view.');
            return back();
        }

        $this->sendClassSignUpEmail($lesson, $newSwimmer);

        $this->sendClassFullEmail($lesson);

        Log::info("Swimmer ID: $newSwimmer->id successfully signed up for lesson ID: $lesson->id");
        session()->flash('success', 'Thanks for signing up! The first lesson is '.$lesson->class_start_date->format('F jS').' at '.$lesson->class_start_time->format('g:i a'));
        return redirect('lessons/'.$lesson->class_type);
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


    /**
     * @param Lesson $lesson
     */
    //TODO: Move this out of the controller
    private function sendClassFullEmail(Lesson $lesson) {
        if($lesson->isLessonFull()){
            try {
                foreach(config('mail.leadDestEmails') as $email){
                    Log::info("Sending lesson full email to $email. Lesson ID: $lesson->id");
                    Mail::to($email)->send(new ClassFull($lesson));
                }
            } catch (\Exception $e) {
                Log::error("Email error: ");
                Log::error(print_r($e, true));
            }
        }
    }

    /**
     * @param Lesson $lesson
     * @param Swimmer $swimmer
     */
    //TODO: Move this out of the controller
    private function sendClassSignUpEmail(Lesson $lesson, Swimmer $swimmer)
    {
        try {
            Mail::to($swimmer->email)->send(new SignUp($lesson));
            Log::info("Group Lesson sign up email sent to $swimmer->email. Swimmer ID: $swimmer->id Lesson ID: $lesson->id.");
        } catch (\Exception $e) {
            Log::error("Email error: ");
            Log::error(print_r($e, true));
        }
    }
}
