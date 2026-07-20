<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public ?string $userName = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Xác thực yêu cầu đặt lại mật khẩu - ' . config('brand.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset_password_otp',
            with: [
                'otp' => $this->otp,
                'userName' => $this->userName,
                'appName' => config('brand.name'),
                'logoText' => config('brand.logo_text'),
                'appUrl' => config('brand.url'),
                'supportEmail' => config('brand.support_email'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}