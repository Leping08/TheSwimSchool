<?php


namespace App\Library\Marketing\Emails;


use App\Mail\SwimTeam\Awards;
use App\STSeason;
use App\STSwimmer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LuauLuncheonEmail
{
    private $season;

    public function __construct(STSeason $season)
    {
        $this->season = $season;
    }

    public function getEmailAddresses()
    {
        return STSwimmer::where('s_t_season_id', $this->season->id)->pluck('email')->unique();
    }

    public function send()
    {
        foreach($this->getEmailAddresses() as $email)
        {
            try{
                Log::info("Sending swim team luau luncheon email to $email");
                Mail::to($email)->send(new Awards());
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        }
    }
}