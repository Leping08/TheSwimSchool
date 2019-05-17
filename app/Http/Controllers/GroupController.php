<?php

namespace App\Http\Controllers;

use App\Banner;
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
        $groups = Group::public()->get();
        $banner = Banner::where('page', '/lessons')->first();
        return view('groups.list', compact('groups', 'banner'));
    }

    /**
     * @param Group $group
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function classDetails(Group $group)
    {
        //Get all lessons for a group that are open for registration
        $group->load(['lessons']); //Eager load the data
        Log::info("Found group ID: $group->id Group Type: $group->type");
        return view('groups.details', compact('group'));
    }

    /**
     * @param Group $group
     * @param Lesson $lesson
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signUp(Group $group, Lesson $lesson)
    {
        $lesson->load(['group', 'location', 'season', 'swimmers']);  //Eager load the data
        Log::info("Found lesson ID: $lesson->id. The Group id for that lesson is: $lesson->group_id");
        return view('groups.signUp', compact('lesson'));
    }
}
