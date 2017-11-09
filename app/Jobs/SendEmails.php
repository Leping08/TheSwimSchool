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
    protected $subject;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $subject, $email)
    {
        $this->data = $data;
        $this->subject = $subject;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new ContactUs($this->data, $this->subject));
        Log::info("$this->subject Email sent to: $this->email.");
    }
}
