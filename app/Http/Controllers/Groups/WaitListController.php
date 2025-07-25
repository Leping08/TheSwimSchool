<?php

namespace App\Http\Controllers\Groups;

use App\Http\Controllers\Controller;
use App\Lesson;
use App\Mail\Admin\WaitList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class WaitListController extends Controller
{
    /**
     * @param  Request  $request
     * @param  Lesson  $lesson
     * @return Redirect
     */
    public function store(Request $request, Lesson $lesson)
    {
        // Stop bots from using this form
        $emptyHoneypot = collect([
            $request->first_name,
            $request->last_name,
            $request->address,
            $request->city,
            $request->state,
            $request->zip,
            $request->country,
        ])->filter()->isEmpty();

        if (! $emptyHoneypot) {
            Log::info('Honeypot fields were not empty.');
            session()->flash('warning', 'Are you a robot?');

            return back();
        }

        // Get the timestamp field and check if it is not within the last 3 seconds
        if ((int) $request->time > (Carbon::now()->timestamp - 3)) {
            Log::info('Timestamp was not within the last 3 seconds.');
            session()->flash('warning', 'Are you a robot?');

            return back();
        }

        // If needed add google recaptcha to the form
        $waitingSwimmer = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|string|max:191',
            'phone' => 'required|max:20',
            'date_of_birth' => 'required',
        ]);

        try {
            $waitingSwimmer['lesson_id'] = $lesson->id;
        } catch (\Exception $e) {
            Log::error($e);
            session()->flash('warning', 'Something has gone wrong. The lesson id in the url does not match the lesson id in the wait list form data.');

            return back();
        }

        if ($lesson->waitlist->count()) {
            foreach ($lesson->waitlist as $swimmer) {
                // Check to see if the same swimmer is signing up again
                if ($swimmer->email === $waitingSwimmer['email'] && $swimmer->name === $waitingSwimmer['name']) {
                    session()->flash('warning', 'Email already on the wait list.');

                    return back();
                }
            }
        }

        $waitingSwimmer['date_of_birth'] = Carbon::parse($waitingSwimmer['date_of_birth'])->format('Y-m-d');

        $newWaitingSwimmer = \App\WaitList::create($waitingSwimmer);

        $this->sendWaitListAdminEmail($lesson);

        Log::info("New swimmer added to the wait list: ID $newWaitingSwimmer->id, Name: $newWaitingSwimmer->name");
        session()->flash('success', 'You have been added to the wait list!');

        return back();
    }

    /**
     * @param  Lesson  $lesson
     */
    private function sendWaitListAdminEmail(Lesson $lesson)
    {
        // Send a wait list filling up email to the admin if the wait list
        Log::info("Sending wait list email to admins about lesson ID: $lesson->id");
        foreach (config('mail.lead_dest_emails') as $email) {
            Log::info("Sending Wait List admin email to $email");
            Mail::to($email)->send(new WaitList($lesson));
        }
    }
}
