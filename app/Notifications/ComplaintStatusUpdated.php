<?php

namespace App\Notifications;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplaintStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public $complaint;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Complaint $complaint, $message = null)
    {
        $this->complaint = $complaint;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Statusupdate klacht #' . $this->complaint->id)
                    ->greeting('Beste ' . $notifiable->name . ',')
                    ->line('De status van uw klacht is gewijzigd.')
                    ->line('Klacht ID: #' . $this->complaint->id)
                    ->line('Categorie: ' . $this->complaint->category)
                    ->line('Nieuwe status: ' . $this->getStatusText($this->complaint->status))
                    ->line($this->message ?: '')
                    ->action('Bekijk klacht', url('/complaints/' . $this->complaint->id))
                    ->line('Bedankt voor uw melding!');
    }

    /**
     * Get the array representation for database storage.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'complaint_id' => $this->complaint->id,
            'status' => $this->complaint->status,
            'message' => $this->message,
            'link' => '/complaints/' . $this->complaint->id,
        ];
    }

    private function getStatusText($status)
    {
        switch($status) {
            case 'new': return 'Nieuw';
            case 'in_progress': return 'In behandeling';
            case 'resolved': return 'Opgelost';
            default: return $status;
        }
    }
}