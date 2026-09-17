<?php

namespace App\Livewire\Agent\Package;

use App\Models\Admin;
use App\Models\AgentPackage;
use App\Models\AgentPackageTransaction;
use App\Notifications\PackagePurchaseNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('layouts.dashboard', ['title' => 'Agent Packages'])]
class View extends Component
{
    use WithFileUploads;

    public $activeCategory = '1';

    public $selectedPackageId = null;

    public $paymentProof;

    public function selectPackage($id)
    {
        $this->selectedPackageId = $id;
    }

    public function submitPayment()
    {
        $this->validate([
            'paymentProof' => 'required|image|max:2048', // Max 2MB
        ]);

        $package = AgentPackage::findOrFail($this->selectedPackageId);

        $packageTransaction = AgentPackageTransaction::create([
            'agent_package_id' => $package->id,
            'agent_id' => Auth::guard('agent')->user()->id,
            'price' => $package->price,
            'coins' => $package->coins,
            'proof' => $this->paymentProof->store('uploads/payment-proofs', 'public'),
            'status' => 'pending',
        ]);

        $admin = Admin::first();
        $admin->notify(new PackagePurchaseNotification($packageTransaction));

        session()->flash('success', 'Payment proof uploaded successfully. Please wait for admin approval.');
        $this->reset(['selectedPackageId', 'paymentProof']);
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.agent.package.view', [
            'packages' => AgentPackage::where('is_active', 1)->get(),
        ]);
    }
}
