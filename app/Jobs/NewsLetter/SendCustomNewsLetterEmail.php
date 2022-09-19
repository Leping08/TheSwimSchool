<?php

namespace App\Jobs\NewsLetter;

use App\Mail\NewsLetter\CustomNewsLetter;
use App\PageParameters;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCustomNewsLetterEmail implements ShouldQueue
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
     * The page parameters model with the email data in the config
     *
     * @var PageParameters
     */
    public $pageParameters;

    /**
     * Create a new message instance.
     *
     * @param  string  $email
     */
    public function __construct(string $email, PageParameters $pageParameters)
    {
        $this->email = $email;
        $this->pageParameters = $pageParameters;
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
            Mail::to($this->email)->send(new CustomNewsLetter(
                $this->email,
                $this->pageParameters->configuration['subject'],
                $this->pageParameters->configuration['body_text'],
                $this->pageParameters->configuration['image_url'],
                $this->pageParameters->configuration['button_url'],
                $this->pageParameters->configuration['button_text']
            ));
            Log::info("Registration open now email successfully sent to $this->email");
        } catch (\Exception $e) {
            Log::warning("Email error: $e");
            throw $e;
        }
    }
}
