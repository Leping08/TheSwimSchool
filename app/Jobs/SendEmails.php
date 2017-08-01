<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;
use App\Mail\Test;
use Log;
use Carbon\Carbon;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $leadDestEmails = config('mail.leadDestEmails');
        $time = Carbon::now('America/New_York');

        foreach($leadDestEmails as $emailAddress){
            Mail::to($emailAddress)->send(new ContactUs($this->data));
            //Mail::to($emailAddress)->send(new Test);
            Log::info('Email sent to: '.$emailAddress.' at '.$time->toDayDateTimeString());
        }
    }
}
