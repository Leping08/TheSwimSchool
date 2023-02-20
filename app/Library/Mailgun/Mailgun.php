<?php

namespace App\Library\Mailgun;

use App\EmailList;
use App\Jobs\NewsLetter\RemoveEmails;
use App\Library\NewsLetter\NewsLetter;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Mailgun
{
    /**
     * @var string
     */
    private static $base_url = 'https://api.mailgun.net/v3/theswimschoolfl.com/';

    /**
     * @return \Illuminate\Support\Collection
     *
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function apiGet(string $path)
    {
        $response = Http::withToken(config('mail.mailers.mailgun.api_token'), 'Basic')
            ->acceptJson()
            ->get(static::$base_url.$path);

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
            $complaints = Mailgun::apiGet('complaints?limit=1000');
        } catch (\Exception $e) {
            Log::error('Error trying to get the list of complaint emails from mailgun');
            Log::error('Error: '.$e->getMessage());
            Log::error('Get trace as string: '.$e->getTraceAsString());

            return;
        }

        collect($complaints->get('items'))->chunk(100)->each(function ($chunk) {
            RemoveEmails::dispatch($chunk->toArray());
        });
    }

    /**
     * @return void
     */
    public static function removeBouncedEmails()
    {
        try {
            $bounces = Mailgun::apiGet('bounces?limit=1000');
        } catch (\Exception $e) {
            Log::error('Error trying to get the list of bounce emails from mailgun');
            Log::error('Error: '.$e->getMessage());
            Log::error('Get trace as string: '.$e->getTraceAsString());

            return;
        }

        $allEmails = EmailList::all();

        collect($bounces->get('items'))->map(function ($bounceEmail) use ($allEmails) {
            $emailList = $allEmails->where('email', trim($bounceEmail['address']))->first();
            if ($emailList) {
                $emailList->update([
                    'subscribe' => false,
                ]);
            }
            Log::info("{$emailList} has unsubscribed.");
        });
    }
}
