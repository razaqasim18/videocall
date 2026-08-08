<?php

namespace App\Livewire\Admin\Agent;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Edit extends Component
{
    public function render()
    {
        return view('livewire.admin.agent.edit');
    }
}
