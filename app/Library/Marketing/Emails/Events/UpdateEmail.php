<?php


namespace App\Library\Marketing\Emails\Events;


use App\EmailList;
use App\Mail\NewsLetter\Update;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UpdateEmail
{
    public static function send()
    {
        $emails = EmailList::where('subscribe', '=', true)->pluck('email')->all();

        foreach($emails as $email)
        {
            try {
                Log::info("Sending Covid update email to : $email");
                Mail::to($email)->send(new Update($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}