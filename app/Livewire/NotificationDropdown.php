<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class NotificationDropdown extends Component
{
    public ?Collection $unreadnotifications;
    public ?Collection $readnotifications;

    protected $listeners = [
        'new-notification' => 'loadNotifications'
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->unreadnotifications = auth()->guard('admin')
            ->user()
            ->unreadNotifications;

        $this->readnotifications = auth()->guard('admin')
            ->user()
            ->readNotifications;

    }

    public function markAllRead()
    {
        auth()->guard('admin')
            ->user()
            ->unreadNotifications
            ->markAsRead();

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.notification-dropdown');
    }
}
