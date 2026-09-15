<?php

namespace App\Livewire\Agent;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard',['title' => 'Agent Dashboard'])]
class Home extends Component
{
    public function render()
    {
        return view('livewire.agent.home');
    }
}
