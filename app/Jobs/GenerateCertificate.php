<?php

namespace App\Jobs;

use App\Mail\Groups\SendCertificate;
use App\Swimmer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;
use Wnx\SidecarBrowsershot\BrowsershotLambda;

class GenerateCertificate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Swimmer
     */
    protected $swimmer;

    /**
     * @var bool
     */
    protected $sendEmail;

    /**
     * Create a new job instance.
     */
    public function __construct(Swimmer $swimmer, $sendEmail = false)
    {
        $this->swimmer = $swimmer;
        $this->sendEmail = $sendEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->swimmer->load(['lesson.group', 'lesson.instructor']);

        // For local testing only
        // $pdf = Browsershot::url('http://127.0.0.1:8001' . '/lessons/groups/certificate/' . Crypt::encryptString($this->swimmer->encryptedId))
        $pdf = BrowsershotLambda::url(route('groups.certificate.show', ['encrypted_swimmer_id' => $this->swimmer->encryptedId]))
            ->windowSize(900, 1400)
            ->paperSize(900, 1400, 'px')
            ->landscape()
            ->showBackground()
            ->margins(0, 0, 0, 0)
            ->pages('1')
            ->pdf();

        // Email the PDF if requested
        if ($this->sendEmail) {
            Mail::to($this->swimmer->email)
                ->sendNow(new SendCertificate($this->swimmer->lesson, $this->swimmer, $pdf));
        }
    }
}
