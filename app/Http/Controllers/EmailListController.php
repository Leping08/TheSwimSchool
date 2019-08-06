<?php

namespace App\Http\Controllers;

use App\EmailList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Library\NewsLetter\NewsLetter;

class EmailListController extends Controller
{
    /**
     * @param EmailList $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unsubscribe(EmailList $email)
    {
        $email->unsubscribe();
        Log::info("EmailListTest ID: {$email->id} with the email {$email->email} has been unsubscribed");

        return view('pages.unsubscribe')->with('email', $email->email);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        if (NewsLetter::subscribe($request->email)) {
            session()->flash('success', 'Thanks for signing up for our news newsletter');

            return back();
        } else {
            session()->flash('warning', 'Looks like something went wrong. We are looking into it.');

            return back();
        }
    }
}
