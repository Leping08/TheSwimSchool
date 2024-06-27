<?php

namespace App\Jobs;

use App\Mail\Groups\SendCertificate;
use App\Swimmer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Spatie\Browsershot\Browsershot;
use Wnx\SidecarBrowsershot\BrowsershotLambda;

class SendLessonCompletedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Swimmer
     */
    protected $swimmer;

    /**
     * Create a new job instance.
     */
    public function __construct(Swimmer $swimmer)
    {
        $this->swimmer = $swimmer;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->swimmer->load(['lesson.group', 'lesson.instructor', 'progressReports.skill']);

        if ($this->swimmer->graduated()) {
            $pdf = $this->generatePdf();
        } else {
            // If the swimmer has not graduated then do not send the PDF
            $pdf = '';
        }

        // Email the PDF if requested
        Mail::to($this->swimmer->email)
            ->sendNow(new SendCertificate($this->swimmer->lesson, $this->swimmer, $pdf));
    }

    /**
     * Generate the PDF certificate.
     */
    protected function generatePdf(): string
    {
        // For local testing only
        // return Browsershot::url('http://127.0.0.1:8001' . '/lessons/groups/certificate/' . $this->swimmer->encryptedId)
        return BrowsershotLambda::url(route('groups.certificate.show', ['encrypted_swimmer_id' => $this->swimmer->encryptedId]))
            ->windowSize(900, 1400)
            ->paperSize(900, 1400, 'px')
            ->landscape()
            ->showBackground()
            ->margins(0, 0, 0, 0)
            ->pages('1')
            ->pdf();
    }
}
