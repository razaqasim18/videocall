<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class TicketNotification extends Notification
{
    use Queueable;

    public Ticket $ticket;

    public string $type; // 'user' or 'agent'

    public string $msgtype;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket, string $type, string $msgtype)
    {
        $this->ticket = $ticket;
        $this->type = $type;
        $this->msgtype = $msgtype;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        // 'database' saves it to the notifications table
        // 'broadcast' sends it in real-time via Pusher/Soketi
        return ['broadcast', 'database'];
    }

    /**
     * This is the data stored in the 'data' column of the notifications table.
     */
    public function toArray($notifiable): array
    {
        return $this->getNotificationData();
    }

    /**
     * This is the data sent in real-time to the frontend.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->getNotificationData());
    }

    private function getNotificationData(): array
    {
        if ($this->msgtype === 'new') {
            $message = ($this->type === 'user')
            ? 'A user has created a new ticket.'
            : 'An agent has created a new ticket.';
        } else {
            $message = ($this->type === 'user')
            ? 'A user has made a reply ticket.'
            : 'An agent has made a reply ticket.';
        }

        return [
            'title' => 'New Support Ticket',
            'message' => $message,
            'ticket_id' => $this->ticket->id,
            'ticket_no' => $this->ticket->ticket_no,
            'subject' => $this->ticket->subject,
            'priority' => $this->ticket->priority,
            'type' => 'ticket',
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
