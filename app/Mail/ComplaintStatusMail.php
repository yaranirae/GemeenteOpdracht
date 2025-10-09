<?php

namespace App\Mail;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $complaint;
    public $statusMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Complaint $complaint, $statusMessage = null)
    {
        $this->complaint = $complaint;
        $this->statusMessage = $statusMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = $this->getStatusText($this->complaint->status);
        
        return new Envelope(
            // ✅ استخدام complaint_number بدلاً من id
            subject: "Klacht Status Update - {$statusText} [Klacht #{$this->complaint->complaint_number}]",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.complaint-status',
            with: [
                'complaint' => $this->complaint,
                'statusMessage' => $this->statusMessage,
                'getStatusText' => function($status) { // ✅ تمرير الدالة للـ view
                    return $this->getStatusText($status);
                }
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }

    private function getStatusText($status)
    {
        switch($status) {
            case 'new': return 'Ontvangen';
            case 'in_progress': return 'In Behandeling';
            case 'resolved': return 'Opgelost';
            default: return $status;
        }
    }
}