<?php

namespace App\Livewire\Admin;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard',['title' => 'Admin Dashboard'])]
class Home extends Component
{
    public function render()
    {
        return view('livewire.admin.home');
    }
}
