<?php

namespace App\Mail;

use App\Models\Cursus;
use App\Models\Eleve;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReinscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $schoolName, $schoolMail, $eleve, $eleveC, $linkDownload;

    /**
     * Create a new message instance.
     */
    public function __construct(String $schoolName, String $schoolMail, Eleve $eleve, Cursus $eleveC, string $linkDownload)
    {
        $this->schoolName = $schoolName;
        $this->schoolMail = $schoolMail;
        $this->eleve = $eleve;
        $this->eleveC = $eleveC;
        $this->linkDownload = $linkDownload;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->schoolMail,
            subject: 'Réinscription de ' . $this->eleve->nom . ' ' . $this->eleve->prenoms . ' a ' . $this->schoolName . ' en ' . $this->eleveC->level,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reinscription',
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
