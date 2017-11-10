<?php

namespace App\Jobs;

use App\Mail\SignUp;
use Illuminate\Support\Facades\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;
use App\Lesson;

class SignupEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $lesson;
    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Lesson $lesson, $email)
    {
        $this->lesson = $lesson;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new SignUp($this->lesson));
        Log::info("Sing-up email sent to: $this->email.");
    }
}
