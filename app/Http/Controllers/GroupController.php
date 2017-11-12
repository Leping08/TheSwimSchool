<?php

namespace App\Http\Controllers;

use App\Group;
use App\Lesson;
use App\Swimmer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Error\Card;
use Illuminate\Support\Facades\Log;
use App\Mail\SignUp;
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
        $group = Group::where('type', $groupType)->get();
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
    public function store(Request $request)
    {
        $group = $request->validate([
            'type' => 'required|string',
            'ages' => 'required|string',
            'description' => 'required|string'
        ]);

        $newGroup = Group::create($group);

        session()->flash('success', "$newGroup->type was created");

        return back();
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
