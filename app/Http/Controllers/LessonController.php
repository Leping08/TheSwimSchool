<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($id)
    {
        $lesson = Lesson::with(['Group', 'Location', 'Season', 'DaysOfTheWeek'])
            ->where('id', '=', $id)
            ->get();
        $days = Lesson::findorfail($id)->DaysOfTheWeek()->get();
        return view('lessons.show', compact('lesson', 'days'));
    }

    public function store(Request $request)
    {
        $lesson = $request->validate([
            'group_id' => 'required|digits_between:1,6',
            'location_id' => 'required|digits_between:1,6',
            'price' => 'required|digits_between:1,3',
            'registration_open' => 'required|string',
            'class_size' => 'required|digits_between:1,3',
            'class_start_time' => 'required|string',
            'class_end_time' => 'required|string',
            'class_start_date' => 'required|string',
            'class_end_date' => 'required|string'
        ]);

        $lesson['registration_open'] = Carbon::parse($lesson['registration_open']);
        $lesson['class_start_time'] = Carbon::parse($lesson['class_start_time']);
        $lesson['class_end_time'] = Carbon::parse($lesson['class_end_time']);
        $lesson['class_start_date'] = Carbon::parse($lesson['class_start_date']);
        $lesson['class_end_date'] = Carbon::parse($lesson['class_end_date']);
        $lesson['season_id'] =  GetSeason::getSeasonFromDate($lesson['class_start_date'])->id;

        $newLesson = Lesson::create($lesson);

        if($request['sunday']){
            $newLesson->DaysOfTheWeek()->attach(1);
        }
        if($request['monday']){
            $newLesson->DaysOfTheWeek()->attach(2);
        }
        if($request['tuesday']){
            $newLesson->DaysOfTheWeek()->attach(3);
        }
        if($request['wednesday']){
            $newLesson->DaysOfTheWeek()->attach(4);
        }
        if($request['thursday']){
            $newLesson->DaysOfTheWeek()->attach(5);
        }
        if($request['friday']){
            $newLesson->DaysOfTheWeek()->attach(6);
        }
        if($request['saturday']){
            $newLesson->DaysOfTheWeek()->attach(7);
        }

        session()->flash('success', $newLesson->group->type.' was created');

        return back();
    }
}
