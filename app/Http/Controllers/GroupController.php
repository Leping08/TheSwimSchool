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
        //Get public facing groups for the groups index page
        return view('groups.list')->with('groups', Group::public());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: Nova dashboard should remove this
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
     * Done in the dashboard
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
        //TODO: Nova dashboard should remove this
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
        //TODO: Nova dashboard should remove this
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
        //TODO: Nova dashboard should remove this
        $request->validate([
            'type' => 'required|string',
            'ages' => 'required|string',
            'description' => 'required|string'
        ]);

        $group->update($request->all());
        Log::info("$group->type has been updated. Group ID: $group->id");
        session()->flash('success_msg', "$group->type has been updated");
        return redirect('/dashboard');
    }


    /**
     *
     * Delete the group
     *
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Group $group)
    {
        //TODO: Nova dashboard should remove this
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


    /**
     *
     * List details of the lesson
     *
     * @param $groupType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function classDetails($groupType)
    {
        //Get all lessons that are open for registration and have not already ended
        Log::info("Trying to find Group Type: $groupType");
        $group = Group::where('type', $groupType)->first();
        Log::info("Found group ID: $group->id Group Type: $group->type");
        return view('groups.details', compact('group'));
    }


    /**
     *
     * Sign up form for that lesson
     *
     * @param $groupType
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signUp($groupType, $id)
    {
        Log::info("Trying to find Lesson ID: $id");
        $lesson = Lesson::with(['group', 'location', 'season'])->where('id', $id)->firstOrFail();
        Log::info("Found lesson ID: $lesson->id. The Group id for that lesson is: $lesson->group_id");
        return view('groups.signUp', compact('lesson'));
    }
}
