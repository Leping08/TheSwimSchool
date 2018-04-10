<?php

namespace App\Http\Controllers;

use App\Group;
use App\Location;
use Carbon\Carbon;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Mail\LessonLink;
use Illuminate\Support\Facades\Mail;

class LessonController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $lesson = Lesson::with(['Group', 'Location', 'Season', 'DaysOfTheWeek'])
            ->where('id', '=', $id)
            ->firstOrFail();
        $days = Lesson::find($id)->DaysOfTheWeek()->get();
        return view('lessons.show', compact('lesson', 'days'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $lesson = $this->validateLesson($request);
        $newLesson = Lesson::create($lesson);
        $this->attachDaysOfTheWeeks($request, $newLesson);
        Log::info($newLesson->group->type." lesson was created. Lesson ID: $newLesson->id.");
        session()->flash('success', $newLesson->group->type.' lesson was created');
        return redirect('/dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        $locations = Location::all();
        $groups = Group::all();
        $daysOfTheWeekArray = $lesson->DaysOfTheWeekArray();
        return view('lessons.edit', compact('lesson', 'locations', 'groups', 'daysOfTheWeekArray'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        $lesson->update($this->validateLesson($request));
        $lesson->DaysOfTheWeek()->detach();
        $this->attachDaysOfTheWeeks($request, $lesson);
        Log::info($lesson->group->type." lesson was updated. Lesson ID: $lesson->id.");
        if($lesson->hasSwimmers()){
            session()->flash('success', $lesson->group->type.' lesson was updated. Make sure to notify all swimmers in the lesson of the changes.');
        }else{
            session()->flash('success', $lesson->group->type.' lesson was updated.');
        }
        return redirect('/lesson/'.$lesson->id);
    }


    /**
     * @param Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Lesson $lesson)
    {
        if(!$lesson->hasSwimmers()){
            Log::info("Lesson ID: $lesson->id was deleted.");
            session()->flash('success', "The lesson was deleted.");
            $lesson->DaysOfTheWeek()->detach();
            $lesson->delete();
            return redirect('/dashboard');
        }else{
            Log::info("$lesson->id can not be deleted. It has swimmers in it.");
            session()->flash('warning', "This lesson can not be deleted. It has swimmers in it.");
            return back();
        }
    }

    public function emailSignUpLink(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $lesson = Lesson::with('group')->find($id);

        if($lesson->isLessonFull()){
            session()->flash('error', "This lesson is full. Add more open spots or make a new lesson.");
            return back();
        }

        Mail::to($request->email)->send(new LessonLink($lesson));
        Log::info("Reserve lesson link email sent to: $request->email");
        session()->flash('success', "Reserve lesson email sent to $request->email.");
        return back();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function validateLesson(Request $request)
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

        return $lesson;
    }

    /**
     * @param Request $request
     * @param Lesson $lesson
     */
    private function attachDaysOfTheWeeks(Request $request, Lesson $lesson)
    {
        if($request['monday']){
            $lesson->DaysOfTheWeek()->attach(1);
        }
        if($request['tuesday']){
            $lesson->DaysOfTheWeek()->attach(2);
        }
        if($request['wednesday']){
            $lesson->DaysOfTheWeek()->attach(3);
        }
        if($request['thursday']){
            $lesson->DaysOfTheWeek()->attach(4);
        }
        if($request['friday']){
            $lesson->DaysOfTheWeek()->attach(5);
        }
        if($request['saturday']){
            $lesson->DaysOfTheWeek()->attach(6);
        }
        if($request['sunday']){
            $lesson->DaysOfTheWeek()->attach(7);
        }
    }
}
