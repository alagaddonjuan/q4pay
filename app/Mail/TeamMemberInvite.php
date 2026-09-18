<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\MerchantTeamMember;

class TeamMemberInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $member;

    public function __construct(MerchantTeamMember $member)
    {
        $this->member = $member;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address(env('MAIL_FROM_ADDRESS', 'info@q4iltd.com'), env('MAIL_FROM_NAME', 'SandboxPay')),
            subject: 'You have been invited to join the Team!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.team.invite',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
