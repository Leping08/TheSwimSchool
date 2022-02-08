<?php

namespace App\Jobs\NewsLetter;

use App\EmailList;
use App\PageParameters;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QueueCustomNewsLetterEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pageParameters = PageParameters::getNewsLetterEmail();

        if (!$pageParameters) {
            throw new \Exception('No email newsletter in the database');
        }

        EmailList::where('subscribe', '=', true)
            ->pluck('email')
            ->map(function ($email) use ($pageParameters) {
                SendCustomNewsLetterEmail::dispatch($email, $pageParameters);
            });
    }
}
