<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth', ['title' => 'Reset Password'])]
class MessagePage extends Component
{
    public string $status;

    public string $message;

    public function mount(int $status, string $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    public function render()
    {
        return view('livewire.message-page');
    }
}
