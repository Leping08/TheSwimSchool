<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailList;
use Illuminate\Support\Facades\Log;

class EmailListController extends Controller
{
    public function unsubscribe($email)
    {
        //TODO: Catch exception where email couldn't be found
        $emailList = EmailList::where('email', '=', $email)->firstOrFail();
        Log::info("Trying to find $email to unsubscribe from email marketing");
        if($emailList->subscribe){
            Log::info("Found $email, EmailList ID: $emailList->id has been unsubscribed");
            $emailList->subscribe = 0;
            $emailList->save();
        }
        return view('pages.unsubscribe', compact('email'));
    }
}
