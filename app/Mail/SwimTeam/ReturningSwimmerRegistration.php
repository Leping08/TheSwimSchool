<?php

namespace App\Mail\SwimTeam;

use App\STSwimmer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReturningSwimmerRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var STSwimmer
     */
    public $swimmer;

    /**
     * @var string
     */
    public $theme = 'the_swim_team';

    /**
     * STSignUp constructor.
     *
     * @param  STSwimmer  $swimmer
     */
    public function __construct(STSwimmer $swimmer)
    {
        $this->swimmer = $swimmer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Returning Swimmer Registration',
            from: config('mail.from.address'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'email.swim-team.returning-swimmer-registration',
            with: ['swimmer' => $this->swimmer],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
