<?php

namespace App\Mail\Groups;

use App\Lesson;
use App\Swimmer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCertificate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The lesson.
     *
     * @var Lesson
     */
    public $lesson;

    /**
     * The swimmer.
     *
     * @var Swimmer
     */
    public $swimmer;

    /**
     * The PDF attachment data as a base 64 encoded string.
     *
     * @var string
     */
    public $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct(Lesson $lesson, Swimmer $swimmer, string $pdf = '')
    {
        $this->lesson = $lesson;
        $this->swimmer = $swimmer;
        $this->pdf = $pdf;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Group Swim Lesson Progress Report',
            from: config('mail.from.address')
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.groups.certificate',
            with: [
                'lesson' => $this->lesson,
                'swimmer' => $this->swimmer,
                'graduated' => ! empty($this->pdf),
                'skills_passed' => $this->swimmer->progressReports->where('passed', true),
                'skills_failed' => $this->swimmer->progressReports->where('passed', false),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // If the PDF is empty then return an empty array
        if (empty($this->pdf)) {
            return [];
        }

        return [
            Attachment::fromData(fn () => $this->pdf, 'certificate.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
