<?php


namespace App\Library\Marketing\Emails\SwimTeam;


use App\EmailList;
use App\Mail\SwimTeam\TryoutsOpen;
use App\STSeason;
use App\STSwimmer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TryoutRegistrationOpen
{
    public static function send(STSeason $season)
    {
        $emailListEmails = collect(EmailList::where('subscribe', '=', true)->pluck('email')->all());
        $swimTeamEmails = collect(STSwimmer::where('s_t_season_id', $season->id)->pluck('email')->all());

        $allEmails = $emailListEmails->merge($swimTeamEmails);

        foreach($allEmails->unique() as $email)
        {
            try {
                Log::info("Sending swim team swim team tryout registration open email to $email");
                Mail::to($email)->send(new TryoutsOpen($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}