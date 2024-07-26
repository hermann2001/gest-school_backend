<?php

namespace App\Mail;

use App\Models\Eleve;
use App\Models\EleveClasse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $schoolName, $eleve, $eleveC;

    /**
     * Create a new message instance.
     */
    public function __construct(String $schoolName, Eleve $eleve, EleveClasse $eleveC)
    {
        $this->schoolName = $schoolName;
        $this->eleve = $eleve;
        $this->eleveC = $eleveC;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Inscription en ' . $this->schoolName,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.inscription',
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
