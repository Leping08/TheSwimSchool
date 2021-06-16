<?php


namespace App\Library\Marketing\Emails\Lessons;


use App\EmailList;
use App\Jobs\NewsLetter\SendRegistrationOpenEmail;

class RegistrationOpenEmail
{
    public static function send()
    {
        EmailList::where('subscribe', '=', true)
            ->pluck('email')
            ->map(function ($email) {
                SendRegistrationOpenEmail::dispatch($email);
            });
    }
}