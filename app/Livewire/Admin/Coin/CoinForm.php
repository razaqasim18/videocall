<?php

namespace App\Livewire\Admin\Coin;

use App\Models\Coin;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class CoinForm extends Component
{
    public $coin_id;

    public $name;

    public $coins;

    public $price;

    public $is_active = false;

    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'coins' => 'required|integer|min:1',
        'price' => 'required|numeric|min:0',
        'is_active' => 'boolean',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $this->isEdit = true;
            $this->coin_id = $id;
            $coin = Coin::findOrFail($id);
            $this->name = $coin->name;
            $this->coins = $coin->coins;
            $this->price = $coin->price;
            $this->is_active = $coin->is_active;
        }
    }

    public function saveCoin()
    {
        $this->validate();

        Coin::updateOrCreate(
            ['id' => $this->coin_id],
            [
                'name' => $this->name,
                'coins' => $this->coins,
                'price' => $this->price,
                'is_active' => $this->is_active,
            ]
        );

        session()->flash('success', $this->isEdit ? 'Coin package updated!' : 'Coin package created!');
        if (! $this->isEdit) {
            $this->reset(['name', 'is_active', 'price', 'coins']);
        }
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.admin.coin.coin-form');
    }
}
