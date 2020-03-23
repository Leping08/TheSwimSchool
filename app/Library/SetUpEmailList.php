<?php

namespace App\Library;

use App\Swimmer;
use App\STSwimmer;
use App\EmailList;
use Illuminate\Support\Facades\Log;

class SetUpEmailList
{
    public function initializeEmailList()
    {
        $emails = \Illuminate\Support\Arr::collapse([$this->getSwimLessonSwimmerEmails(), $this->getSwimTeamSwimmerEmails()]);

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
