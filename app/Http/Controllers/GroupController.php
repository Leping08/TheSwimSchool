<?php

namespace App\Http\Controllers;

use App\Group;
use App\Lesson;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        return view('groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
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
        //validate post data
        $request->validate([
            'type' => 'required|string',
            'ages' => 'required|string',
            'description' => 'required|string'
        ]);

        Group::find($group->id)->update($request->all());
        session()->flash('success_msg', "$group->type has been updated");
        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $lessons = $group->Lessons()->get();
        if($lessons->isEmpty()){
            session()->flash('success', "$group->type was deleted.");
            $group->delete();
            return redirect('/dashboard');
        }else{
            session()->flash('warning', "$group->type can not be deleted. It has lessons associated with it.");
            return back();
        }
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

    //Get request to the terms and conditions url
    public function terms($classType, $id)
    {
        return view('groups.terms');
    }
}
