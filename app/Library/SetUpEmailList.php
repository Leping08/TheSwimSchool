<?php

namespace App\Library;

use App\Models\Tryout;
use App\Models\Swimmer;
use App\Models\EmailList;
use App\Models\STSwimmer;
use Carbon\Carbon;
use App\Mail\TryoutReminder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SetUpEmailList
{
    public function initializeEmailList()
    {
        $emails = array_merge($this->getSwimLessonSwimmerEmails(), $this->getSwimTeamSwimmerEmails());

        Log::info('Setting up the email list with emails from the swim lessons and swim team swimmers');
        foreach ($emails as $email) {
            $emailList = EmailList::firstOrCreate(['email' => $email]);
            Log::info("Email added to the list: $emailList->email");
        }
    }

    private function getSwimLessonSwimmerEmails(): array
    {
        return Swimmer::where('stripeChargeId', '!=', null)->pluck('email')->unique()->values()->all();
    }

    private function getSwimTeamSwimmerEmails(): array
    {
        return STSwimmer::pluck('email')->unique()->values()->all();
    }
}
