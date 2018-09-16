<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Mail\WaitListAdmin;
use App\WaitList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class WaitListController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
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

        $this->sendWaitListAdminEmail($lesson);

        Log::info("New swimmer added to the wait list: ID $newWaitingSwimmer->id, Name: $newWaitingSwimmer->name");
        session()->flash('success', 'You have been added to the wait list!');
        return back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $waitingSwimmer = WaitList::with('lesson')->find($id);
        return view('wait-list.show', compact('waitingSwimmer'));
    }

    /**
     * @param Lesson $lesson
     */
    private function sendWaitListAdminEmail(Lesson $lesson)
    {
        // Send a wait list filling up email to the admin if the wait list
        // has half of the class size or more waiting swimmers
        if(($lesson->waitlist->count()) >= ($lesson->class_size/2)) {
            Log::info("Sending wait list email to admins about lesson ID: $lesson->id");
            foreach(config('mail.leadDestEmails') as $email){
                Log::info("Sending Wait List admin email to $email");
                Mail::to($email)->send(new WaitListAdmin($lesson));
            }
        }
    }
}