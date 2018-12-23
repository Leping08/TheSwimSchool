<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailList;
use Illuminate\Support\Facades\Log;

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
}
