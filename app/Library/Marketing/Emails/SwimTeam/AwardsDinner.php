<?php

namespace App\Library\Marketing\Emails\SwimTeam;

use App\Mail\SwimTeam\Awards;
use App\STSeason;
use App\STSwimmer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AwardsDinner
{
    public static function getEmailAddresses()
    {
        $currentSeason = STSeason::where('current_season', true)->first();

        return STSwimmer::where('s_t_season_id', $currentSeason->id)
            ->pluck('email')
            ->unique();
    }

    public static function send()
    {
        foreach (self::getEmailAddresses() as $email) {
            try {
                Log::info("Sending swim team awards email to $email");
                Mail::to($email)->queue(new Awards());
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}
