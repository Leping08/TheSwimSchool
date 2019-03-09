<?php


namespace App\Library;

use App\Models\EmailList;
use App\Mail\GoldDaisyAward;
use App\Mail\HappyHolidays;
use App\Mail\RegistrationOpen;
use App\Mail\RegistrationOpeningSoon;
use App\Mail\SpringRegistration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MarketingEmails
{
    public function getSubscribedEmails(): Array
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

    public function sendLessonRegistrationOpeningEmails()
    {
        foreach ($this->getSubscribedEmails() as $email) {
            try {
                Log::info("Sending lesson registration opening soon email to $email");
                Mail::to($email)->send(new SpringRegistration($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }

    public function sendSpringLessonRegistrationOpeningSoonEmails()
    {
        foreach ($this->getSubscribedEmails() as $email) {
            try {
                Log::info("Sending lesson registration opening soon email to $email");
                Mail::to($email)->send(new RegistrationOpeningSoon($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }

    public function sendGoldDaisyAwardEmails()
    {
        foreach ($this->getSubscribedEmails() as $email) {
            try {
                Log::info("Sending Gold Daisy Award Email email to $email");
                Mail::to($email)->send(new GoldDaisyAward($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }

    public function sendHappyHolidaysEmails()
    {
        foreach ($this->getSubscribedEmails() as $email) {
            try {
                Log::info("Sending Happy Holidays Email email to $email");
                Mail::to($email)->send(new HappyHolidays($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}
