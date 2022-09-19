<?php

namespace App\Library\Marketing\Emails\Events;

use App\EmailList;
use App\Mail\Newsletter\HappyHolidays;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ParrishChristmasTreeLighting
{
    public function getSubscribedEmails(): array
    {
        return EmailList::where('subscribe', '=', true)->pluck('email')->all();
    }

    public function send()
    {
        foreach ($this->getSubscribedEmails() as $email) {
            try {
                Log::info("Parrish christmas tree lighting email to: $email");
                Mail::to($email)->send(new HappyHolidays($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}
