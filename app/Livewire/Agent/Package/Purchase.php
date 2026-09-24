<?php

namespace App\Livewire\Agent\Package;

use App\Models\Admin;
use App\Models\AgentPackage;
use App\Models\AgentPackageTransaction;
use App\Notifications\PackagePurchaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('layouts.dashboard', ['title' => 'Agent Packages'])]
class Purchase extends Component
{
    use WithFileUploads;

    public $activeCategory = '1';

    public $selectedPackageId = null;

    public $paymentProof;

    public $existingTransaction; // To store the pending record for "Edit" mode

    public function mount()
    {
        // Find a pending transaction for this agent to allow them to "Edit" it
        $this->existingTransaction = AgentPackageTransaction::where('agent_id', Auth::guard('agent')->id())
            ->where('status', 'pending')
            ->first();

        if ($this->existingTransaction) {
            $this->selectedPackageId = $this->existingTransaction->agent_package_id;
        }
    }

    public function selectPackage($id)
    {
        $this->selectedPackageId = $id;
    }

    public function submitPayment()
    {
        $this->validate([
            'selectedPackageId' => 'required',
            'paymentProof' => $this->existingTransaction ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        $package = AgentPackage::findOrFail($this->selectedPackageId);
        $agentId = Auth::guard('agent')->user()->id;
        // Notify Admin
        $admin = Admin::first();

        if ($this->existingTransaction) {
            $transaction = $this->existingTransaction;
            $transaction->update([
                'agent_package_id' => $package->id,
                'price' => $package->price,
                'coins' => $package->coins,
            ]);

            if ($this->paymentProof) {
                // Delete old file manually
                if ($transaction->proof) {
                    Storage::disk('public')->delete($transaction->proof);
                }
                // Store new file manually
                $transaction->proof = $this->paymentProof->store('payment-proofs', 'public');
                $transaction->save();
            }
            if ($admin) {
                $admin->notify(new PackagePurchaseNotification($transaction, 'update'));
            }
        } else {
            $transaction = AgentPackageTransaction::create([
                'agent_package_id' => $package->id,
                'agent_id' => $agentId,
                'price' => $package->price,
                'coins' => $package->coins,
                'status' => 'pending',
                'proof' => $this->paymentProof->store('payment-proofs', 'public'),
            ]);
        }

        if ($admin) {
            $admin->notify(new PackagePurchaseNotification($transaction, 'new'));
        }

        session()->flash('success', 'Payment proof submitted successfully. Please wait for admin approval.');

        $this->reset(['selectedPackageId', 'paymentProof']);
        $this->existingTransaction = null; // Clear existing after successful submit
        $this->dispatch('scroll-to-top');
    }

    public function render()
    {
        return view('livewire.agent.package.purchase', [
            'packages' => AgentPackage::where('is_active', 1)->get(),
        ]);
    }
}
