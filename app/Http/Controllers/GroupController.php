<?php

namespace App\Http\Controllers;

use App\Group;
use App\Lesson;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Error\Card;
use Illuminate\Support\Facades\Log;
use App\Mail\LessonSignUp;
use Illuminate\Support\Facades\Mail;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        return view('groups.list', compact('groups'));
    }




    //list details of the lesson
    public function classDetails($groupType)
    {
        //Get all lessons that are open for registration and have not already ended
        $group = Group::with(['Lessons' => function ($query) {
                $query->where('registration_open', '<=', Carbon::now())
                      ->where('class_end_date', '>=', Carbon::now())
                      ->with('location');
            }])->where('type', $groupType)->get();
        $group = $group[0];
        return view('groups.details', compact('group'));
    }



    //sign up form for that lesson
    public function signUp($groupType, $id)
    {
        $lesson = Lesson::with(['group', 'location', 'season'])->where('id', $id)->get();
        $lesson = $lesson[0];
        return view('groups.signUp', compact('lesson'));
    }


    //Sign a swimmer up for a lesson and send them to the card payment page or back to the lesson page.
    public function store(Request $request, $classType, $id)
    {
        //valadate data
        $this->validate(request(), [
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
            'emergencyPhone' => 'required|max:20',
            'payment' => 'required'
        ]);

        $lesson = Lesson::findOrFail($id);

        $newSwimmer = Swimmer::create([
            'name' => request('name'),
            'age' => request('age'),
            'email' => request('email'),
            'phone' => request('phone'),
            'parent' => request('parent'),
            'street' => request('street'),
            'city' => request('city'),
            'state' => request('state'),
            'zip' => request('zip'),
            'emergencyName' => request('emergencyName'),
            'emergencyRelationship' => request('emergencyRelationship'),
            'emergencyPhone' => request('emergencyPhone'),
            'lesson_id' => $lesson->id
        ]);

        //If the user is using a card for payment, send them to the card view with the user id.
        if(request('payment') === 'card'){
            Mail::to($newSwimmer->email)->send(new LessonSignUp($lesson));
            return view('lessons.cardCheckout', compact('newSwimmer', 'lesson'));
            //If they are paying in person, redirect them to the class they signed up for with success alert.
        }elseif(request('payment') === 'check'){
            //Email the swimmer a confurmation email
            Mail::to($newSwimmer->email)->send(new LessonSignUp($lesson));
            $request->session()->flash('success', 'You are all signed up! First lesson is '.$lesson->class_start_date->toFormattedDateString().' at '.$lesson->class_start_time->format('H:i A').'. Be sure to bring cash or check for $'.$lesson->price.' to the first lesson.');
            return redirect('lessons/'.$lesson->class_type);
        }else{
            $request->session()->flash('danger', 'Looks like something went wrong.');
        }
    }

    //Get request to the terms and conditions url
    public function terms($classType, $id)
    {
        return view('groups.terms');
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
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
}
