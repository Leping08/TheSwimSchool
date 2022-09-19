<?php

namespace App\Library\Marketing\Emails\Events;

use App\EmailList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Covid
{
    public function getSubscribedEmails(): array
    {
        return EmailList::where('subscribe', '=', true)->pluck('email')->all();
    }

    public function getSeasonFifteenEmails(): array
    {
        return \App\Lesson::where('location_id', 5)
            ->where('season_id', 15)
            ->with('swimmers')
            ->get()
            ->pluck('swimmers')
            ->map(function ($swimmers) {
                return collect($swimmers)->map(function ($swimmer) {
                    return $swimmer->email;
                });
            })
            ->flatten()
            ->values()
            ->all();
    }

    public function send()
    {
        foreach ($this->getSeasonFifteenEmails() as $email) {
            try {
                Log::info("Sending Covid email to: $email");
                Mail::to($email)->send(new \App\Mail\NewsLetter\Covid($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}
