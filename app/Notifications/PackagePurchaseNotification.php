<?php

namespace App\Notifications;

use App\Models\AgentPackageTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PackagePurchaseNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public AgentPackageTransaction $package;

    public string $type;

    public function __construct($package, $type)
    {
        $this->package = $package;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        $message = $this->type == 'new' ? $this->package->package->name.' package is purchased' : $this->package->package->name.' updated its purchased';

        return [
            'title' => 'New Package package',
            'message' => $message,
            'package_id' => $this->package->id,
            'agent_id' => $this->package->agent_id,
            'agent_package_transactions' => $this->package->id,
            'type' => 'package_purchase',
        ];
    }

    public function toBroadcast($notifiable)
    {
        $message = $this->type == 'new' ? $this->package->package->name.' package is purchased' : $this->package->package->name.' updated its purchased';

        return new BroadcastMessage([
            'title' => 'New Package package',
            'message' => $message,
            'package_id' => $this->package->id,
            'agent_id' => $this->package->agent_id,
            'agent_package_transactions' => $this->package->id,
            'type' => 'package_purchase',
        ]);
    }
}
