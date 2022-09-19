<?php

namespace App\Http\Controllers\Groups;

use App\Banner;
use App\Group;
use App\Http\Controllers\Controller;
use App\Lesson;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public static function index()
    {
        //Get public facing groups for the groups index page
        $groups = Group::public()->get();
        $banner = Banner::where('page', '/lessons')->first();

        return view('groups.list', compact('groups', 'banner'));
    }

    /**
     * @param  Group  $group
     * @return View
     */
    public static function show(Group $group)
    {
        //Get all lessons for a group that are open for registration
        $group->load(['lessons']); //Eager load the data
        Log::info("Found group ID: $group->id Group Type: $group->type");
        //TODO: Get DB logic out of the view
        return view('groups.details', compact('group'));
    }

    /**
     * @param  Group  $group
     * @param  Lesson  $lesson
     * @return View
     */
    public function create(Group $group, Lesson $lesson)
    {
        $lesson->load(['group', 'location', 'season', 'swimmers']);  //Eager load the data
        Log::info("Found lesson ID: $lesson->id. The Group id for that lesson is: $lesson->group_id");

        return view('groups.signUp', compact('lesson'));
    }
}
