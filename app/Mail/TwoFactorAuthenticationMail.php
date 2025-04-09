<?php

namespace App\Mail;

use App\Http\DTO\Auth\TwoFactorAuthenticationMailData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorAuthenticationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected TwoFactorAuthenticationMailData $contentInfo;

    /**
     * Create a new message instance.
     */
    public function __construct(TwoFactorAuthenticationMailData $contentInfo)
    {
        $this->contentInfo = $contentInfo;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[S-NET] 二要素認証の確認リンク',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.authentication', with: ['contentInfo' => $this->contentInfo]
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
