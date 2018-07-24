<?php

namespace App\Library;

use App\Mail\TryoutReminder;
use App\Swimmer;
use App\STSwimmer;
use App\EmailList;
use Illuminate\Support\Collection;
use App\Tryout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SetUpEmailList
{
    public function initializeEmailList()
    {
        $emails = array_merge($this->getSwimLessonSwimmerEmails(), $this->getSwimTeamSwimmerEmails());

        Log::info("Setting up the email list with emails from the swim lessons and swim team swimmers");
        foreach ($emails as $email){
            $emailList = EmailList::firstOrCreate(['email' => $email]);
            Log::info("Email added to the list: $emailList->email");
        }
    }

    private function getSwimLessonSwimmerEmails(): array
    {
        return Swimmer::where('stripeChargeId', '!=', NULL)->pluck('email')->unique()->values()->all();
    }

    private function getSwimTeamSwimmerEmails(): array
    {
        return STSwimmer::pluck('email')->unique()->values()->all();
    }
}
