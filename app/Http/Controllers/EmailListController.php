<?php

namespace App\Http\Controllers;

use App\EmailList;
use App\Library\NewsLetter\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EmailListController extends Controller
{
    /**
     * @param  EmailList  $email
     * @return View
     */
    public function unsubscribe(EmailList $email)
    {
        $email->unsubscribe();
        Log::info("EmailList ID: {$email->id} with the email {$email->email} has been unsubscribed");

        return view('pages.unsubscribe')->with('email', $email->email);
    }

    /**
     * @param  Request  $request
     * @return Redirect
     */
    public function subscribe(Request $request)
    {
        // Check if all honeypot fields are empty
        $emptyHoneypot = collect([
            $request->email_address,
            $request->emailaddress,
        ])->filter()->isEmpty();

        if (!$emptyHoneypot) {
            Log::info('Honeypot fields were not empty.');
            session()->flash('warning', 'Are you a robot?');
            return back();
        }

        // Get the timestamp field and check if it is not within the last 3 seconds
        if ((int)$request->time > (Carbon::now()->timestamp - 3)) {
            Log::info('Timestamp was not within the last 3 seconds.');
            session()->flash('warning', 'Are you a robot?');
            return back();
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        if (NewsLetter::subscribe($request['email'])) {
            session()->flash('success', 'Thanks for signing up for our newsletter!');

            return back();
        } else {
            session()->flash('warning', 'Looks like something went wrong. We are looking into it.');

            return back();
        }
    }
}
