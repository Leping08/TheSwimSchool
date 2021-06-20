<?php


namespace App\Library\Marketing\Emails\Lessons;


use App\EmailList;
use App\Jobs\NewsLetter\SendRegistrationOpenEmail;

//\App\Library\Marketing\Emails\Lessons\RegistrationOpenEmail::send();

class RegistrationOpenEmail
{
    public static function send()
    {
        EmailList::where('subscribe', '=', true)
            ->where('id', '>=', 200)
            ->pluck('email')
            ->map(function ($email) {
                SendRegistrationOpenEmail::dispatch($email);
            });
    }
}