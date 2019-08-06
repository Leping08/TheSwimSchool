<?php

namespace App\Library;

use App\EmailList;
use App\Mail\TryoutsOpen;
use App\Mail\HappyHolidays;
use App\Mail\GoldDaisyAward;
use App\Mail\RegistrationOpen;
use App\Mail\SpringRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationOpeningSoon;

class MarketingEmails
{
    public function getSubscribedEmails(): array
    {
        return EmailList::where('subscribe', '=', true)->pluck('email')->all();
    }

    public function sendLessonRegistrationOpenEmails()
    {
        foreach ($this->getSubscribedEmails() as $email) {
            try {
                Log::info("Sending lesson registration open now email to $email");
                Mail::to($email)->send(new RegistrationOpen($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}
