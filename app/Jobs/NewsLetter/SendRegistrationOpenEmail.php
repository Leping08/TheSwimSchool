<?php

namespace App\Jobs\NewsLetter;

use App\Mail\NewsLetter\RegistrationOpen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRegistrationOpenEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 1;

    /**
     * The email address where the email will be sent
     *
     * @var string
     */
    public $email;

    /**
     * Create a new message instance.
     *
     * @param  string  $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handle()
    {
        try {
            Log::info("Sending registration open now email to $this->email");
            Mail::to($this->email)->send(new RegistrationOpen($this->email));
            Log::info("Registration open now email successfully sent to $this->email");
        } catch (\Exception $e) {
            Log::warning("Email error: $e");
            throw $e;
        }
    }
}
