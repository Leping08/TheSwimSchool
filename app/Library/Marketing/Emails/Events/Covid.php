<?php


namespace App\Library\Marketing\Emails\Events;


use App\EmailList;
use App\Mail\NewsLetter\HappyHolidays;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Covid
{
    public function getSubscribedEmails(): Array
    {
        return EmailList::where('subscribe', '=', true)->pluck('email')->all();
    }

    public function send()
    {
        foreach($this->getSubscribedEmails() as $email)
        {
            try {
                Log::info("Sending Covid email to : $email");
                Mail::to($email)->send(new \App\Mail\NewsLetter\Covid($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}