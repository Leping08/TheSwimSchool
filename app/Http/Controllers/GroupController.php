<?php

namespace App\Http\Controllers;

use App\Group;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $request->validate([
            'type' => 'required|string',
            'ages' => 'required|string',
            'description' => 'required|string'
        ]);

        $newGroup = Group::create($request->all());
        Log::info("$newGroup->type has been created. Group ID: $newGroup->id");
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
        //Done in dashboard
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $group = Group::find($group->id);
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
        $group = Group::find($group->id);
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
        $request->validate([
            'type' => 'required|string',
            'ages' => 'required|string',
            'description' => 'required|string'
        ]);

        Group::find($group->id)->update($request->all());
        Log::info("$group->type has been updated. Group ID: $group->id");
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
            Log::info("$group->type was deleted. Group ID: $group->id");
            session()->flash('success', "$group->type was deleted.");
            $group->delete();
            return redirect('/dashboard');
        }else{
            Log::info("$group->type can not be deleted. It has lessons associated with it. Group ID: $group->id");
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
