<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\WaitList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WaitListController extends Controller
{
    public function store(Request $request, $id)
    {
        $waitingSwimmer = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191',
            'phone' => 'required|max:20'
        ]);

        try{
            $lesson = Lesson::findOrFail($id);
            $waitingSwimmer['lesson_id'] = $lesson->id;
        }catch (\Exception $e){
            Log::error($e);
            //TODO: Return a message back to the user here
        }

        $newWaitingSwimmer = WaitList::create($waitingSwimmer);

        Log::info("New swimmer added to the wait list: ID $newWaitingSwimmer->id, Name: $newWaitingSwimmer->name");
        session()->flash('success', 'You have been added to the wait list!');
        return back();
    }
}
