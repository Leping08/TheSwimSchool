<?php

namespace App\Http\Controllers;

use App\Group;
use App\Lesson;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
