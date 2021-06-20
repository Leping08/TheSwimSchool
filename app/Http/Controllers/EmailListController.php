<?php

namespace App\Http\Controllers;

use App\Library\NewsLetter\NewsLetter;
use Illuminate\Http\Request;
use App\EmailList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class EmailListController extends Controller
{

    /**
     * @param EmailList $email
     * @return View
     */
    public function unsubscribe(EmailList $email)
    {
        $email->unsubscribe();
        Log::info("EmailList ID: {$email->id} with the email {$email->email} has been unsubscribed");
        return view('pages.unsubscribe')->with('email', $email->email);
    }


    /**
     * @param Request $request
     * @return Redirect
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        if(NewsLetter::subscribe($request['email'])){
            session()->flash('success', 'Thanks for signing up for our newsletter!');
            return back();
        } else {
            session()->flash('warning', 'Looks like something went wrong. We are looking into it.');
            return back();
        }
    }
}
