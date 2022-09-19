<?php

namespace App\Library;

use App\Mail\SwimTeam\TryoutReminder;
use App\Tryout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TryoutReminderEmail
{
    public function sendReminderEmails()
    {
        $tryouts = $this->getTryoutsStartingTomorrow();
        if (count($tryouts)) {
            foreach ($tryouts as $tryout) {
                foreach ($tryout->athletes as $athlete) {
                    if ($athlete->email) {
                        try {
                            Log::info("Sending tryout reminder email to $athlete->email for tryout ID: $tryout->id");
                            Mail::to($athlete->email)->send(new TryoutReminder($tryout));
                        } catch (\Exception $e) {
                            Log::warning("Email error: $e");
                        }
                    }
                }
            }
        } else {
            Log::info('No tryouts tomorrow.');
        }
    }

    private function getTryoutsStartingTomorrow()
    {
        return Tryout::whereDate('event_time', Carbon::tomorrow())->with('Athletes', 'Location')->get();
    }
}
