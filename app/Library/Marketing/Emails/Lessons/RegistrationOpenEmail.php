<?php

namespace App\Library\Marketing\Emails\Lessons;

use App\EmailList;
use App\Jobs\NewsLetter\SendRegistrationOpenEmail;
use App\Library\Mailgun\Mailgun;

// \App\Library\Marketing\Emails\Lessons\RegistrationOpenEmail::send();

class RegistrationOpenEmail
{
    public static function send()
    {
        Mailgun::removeComplaintsEmails();

        EmailList::where('subscribe', '=', true)
            ->pluck('email')
            ->map(function ($email) {
                SendRegistrationOpenEmail::dispatch($email);
            });
    }
}
