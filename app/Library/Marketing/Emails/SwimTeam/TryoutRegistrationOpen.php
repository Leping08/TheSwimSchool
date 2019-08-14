<?php


namespace App\Library\Marketing\Emails\SwimTeam;


use App\EmailList;
use App\Mail\Awards;
use App\Mail\TryoutsOpen;
use App\STSeason;
use App\STSwimmer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TryoutRegistrationOpen
{
    private $season;

    public function __construct(STSeason $season)
    {
        $this->season = $season;
    }

    public function getEmailAddresses(): Collection
    {
        $emailListEmails = collect(EmailList::where('subscribe', '=', true)->pluck('email')->all());
        $swimTeamEmails = collect(STSwimmer::where('s_t_season_id', $this->season->id)->pluck('email')->all());

        $allEmails = $emailListEmails->merge($swimTeamEmails);

        return $allEmails->unique();
    }

    public function send()
    {
        foreach($this->getEmailAddresses() as $email)
        {
            try{
                //Log::info("Going to send swim team swim team tryout registration open email to $email");
                Log::info("Sending swim team swim team tryout registration open email to $email");
                Mail::to($email)->send(new TryoutsOpen($email));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}