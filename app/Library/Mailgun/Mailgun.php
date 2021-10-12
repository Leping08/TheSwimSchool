<?php

namespace App\Library\Mailgun;

use App\Library\NewsLetter\NewsLetter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Mailgun
{
    /**
     * @return \Illuminate\Support\Collection
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function complaints()
    {
        $response = Http::withToken(config('mail.mailers.mailgun.api_token'), 'Basic')
            ->acceptJson()
            ->get('https://api.mailgun.net/v3/theswimschoolfl.com/complaints');

        $response->throw();

        if ($response->ok()) {
            return $response->collect();
        }
    }

    /**
     * @return void
     */
    public static function removeComplaintsEmails()
    {
        try {
            $complaints = Mailgun::complaints();
        } catch (\Exception $e) {
            Log::error('Error trying to get the list of complaint emails from mailgun');
            Log::error('Error: ' . $e->getMessage());
            Log::error('Get trace as string: ' . $e->getTraceAsString());
            return;
        }

        collect($complaints->get('items'))->map(function($complaintEmail) {
            NewsLetter::unsubscribe($complaintEmail['address']);
        });
    }
}