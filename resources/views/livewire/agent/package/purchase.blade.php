<div class="pb-20 space-y-12">
    <!-- Header Section -->
    <div>
        <x-header-section headerwprimary="Package" headerwsecondary="Plans"
            tagline="Select a package that fits your fitness goals and upload payment proof." />
    </div>

    <!-- Alerts Section -->
    <div id="successdiv" class="max-w-3xl mx-auto">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>

    <!-- Packages Grid -->
    <div class="grid items-stretch max-w-6xl grid-cols-1 gap-8 mx-auto md:grid-cols-3">
        @foreach ($packages as $package)
            <div
                class="group relative p-8 transition-all duration-300 border shadow-sm rounded-3xl bg-surface hover:shadow-xl hover:-translate-y-2
                {{ $selectedPackageId == $package->id
                    ? 'ring-4 ring-primary border-primary bg-primary/5'
                    : 'border-dark/10 hover:border-primary/40' }}">

                <!-- Selected Badge -->
                @if ($selectedPackageId == $package->id)
                    <div
                        class="absolute -top-3 right-8 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-white bg-primary rounded-full shadow-lg">
                        Selected
                    </div>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold transition-colors text-dark group-hover:text-primary">
                        {{ $package->name }}
                    </h3>
                </div>

                <div class="mb-8">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold tracking-tight text-dark">
                            Rs {{ number_format($package->price) }}
                        </span>
                        <span class="text-lg font-medium text-dark/50">
                            / {{ $package->coins }} Coins
                        </span>
                    </div>

                    @if ($package->description)
                        <p class="mt-3 text-sm leading-relaxed text-dark/60">
                            {{ $package->description }}
                        </p>
                    @endif
                </div>

                <button wire:click="selectPackage({{ $package->id }})"
                    class="cursor-pointer block w-full py-4 font-bold text-center transition-all duration-300 border rounded-2xl
                    {{ $selectedPackageId == $package->id
                        ? 'bg-green-500 text-white border-green-500 shadow-lg shadow-green-200 hover:bg-green-600'
                        : 'bg-white text-primary border-primary/20 hover:bg-primary hover:text-white hover:border-primary' }}">
                    {{ $selectedPackageId == $package->id ? '✓ Package Selected' : 'Select Package' }}
                </button>
            </div>
        @endforeach
    </div>

    <!-- PAYMENT PROOF UPLOAD SECTION -->
    @if ($selectedPackageId)
        <div
            class="relative max-w-2xl p-8 mx-auto overflow-hidden bg-white border shadow-2xl rounded-3xl border-primary/10 animate-fade-in">
            <!-- Decorative background element -->
            <div class="absolute top-0 right-0 w-32 h-32 -mt-16 -mr-16 rounded-full bg-primary/5"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 bg-primary/10 rounded-2xl">
                        <x-heroicon-s-credit-card class="w-6 h-6 text-primary" />
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-dark">Complete Your Purchase</h3>
                        <p class="text-sm text-dark/60">Securely upload your payment proof for verification.</p>
                    </div>
                </div>

                <!-- Package Summary Card -->
                <div
                    class="flex items-center justify-between p-4 mb-8 border border-gray-300 border-dashed rounded-2xl bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-primary"></div>
                        <span class="text-sm font-medium text-dark/70">
                            Selected: <span class="font-bold text-dark">
                                {{ $packages->firstWhere('id', $selectedPackageId)->name ?? 'Package' }}
                            </span>
                        </span>
                    </div>
                    <span class="text-sm font-bold text-primary">
                        Rs {{ number_format($packages->firstWhere('id', $selectedPackageId)->price ?? 0) }}
                    </span>
                </div>

                <div class="space-y-6">
                    <div class="flex flex-col gap-3">
                        <label class="ml-1 text-sm font-semibold text-dark/70">Payment Screenshot</label>

                        <div class="relative group">
                            <!-- File Input -->
                            <input type="file" wire:model="paymentProof"
                                class="block w-full p-2 text-sm transition-all border border-gray-200 cursor-pointer text-dark file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-primary file:text-white hover:file:bg-primary/90 bg-gray-50 rounded-2xl"
                                accept="image/*" />

                            <!-- PREVIEW LOGIC -->
                            @if ($paymentProof)
                                <!-- A: Preview of NEWLY selected file (Temporary Livewire URL) -->
                                <div
                                    class="relative p-2 mt-4 border border-gray-200 rounded-2xl bg-gray-50 group/preview">
                                    <div
                                        class="relative flex items-center justify-center h-48 overflow-hidden bg-gray-200 rounded-xl">
                                        <img src="{{ $paymentProof->temporaryUrl() }}"
                                            class="object-contain w-full h-full transition-transform duration-300 max-h-48 group-hover/preview:scale-105"
                                            alt="Payment Preview" />

                                        <button type="button" wire:click="$set('paymentProof', null)"
                                            class="absolute p-2 text-white transition-all scale-0 bg-red-500 rounded-full shadow-lg top-2 right-2 hover:bg-red-600 group-hover/preview:scale-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-center text-dark/40">
                                        New file selected: {{ $paymentProof->getClientOriginalName() }}
                                    </p>
                                </div>
                            @elseif ($existingTransaction && $existingTransaction->proof)
                                <!-- B: Preview of EXISTING file from DB (Standard Laravel Storage) -->
                                <div
                                    class="relative p-2 mt-4 border border-primary/20 rounded-2xl bg-primary/5 group/preview">
                                    <div
                                        class="relative flex items-center justify-center h-48 overflow-hidden bg-gray-200 rounded-xl">
                                        {{-- Use Storage::url() instead of getFirstMediaUrl() --}}
                                        <img src="{{ \Storage::url($existingTransaction->proof) }}"
                                            class="object-contain w-full h-full transition-transform duration-300 max-h-48 group-hover/preview:scale-105"
                                            alt="Current Proof" />

                                        <div
                                            class="absolute top-2 left-2 px-2 py-1 text-[10px] font-bold uppercase text-white bg-green-500 rounded-md shadow-sm">
                                            Current Proof
                                        </div>
                                    </div>
                                    <p class="mt-2 text-xs font-medium text-center text-dark/40">
                                        Your current proof is uploaded. Upload a new one to replace it.
                                    </p>
                                </div>
                            @endif


                            <!-- Uploading Spinner -->
                            <div wire:loading wire:target="paymentProof"
                                class="absolute inset-0 z-10 flex items-center justify-center bg-white/80 rounded-2xl">
                                <div class="flex items-center gap-2 text-sm font-medium text-primary">
                                    <svg class="w-4 h-4 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.291z">
                                        </path>
                                    </svg>
                                    Uploading...
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button wire:click="submitPayment" wire:loading.attr="disabled"
                            class="flex items-center justify-center flex-1 gap-2 py-4 font-bold text-white transition-all shadow-lg bg-primary rounded-2xl hover:bg-primary/90 shadow-primary/30 active:scale-95 disabled:opacity-70 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="submitPayment">Submit Payment Proof</span>
                            <span wire:loading wire:target="submitPayment"
                                class="flex items-center gap-2">Submitting...</span>
                        </button>

                        <button wire:click="$set('selectedPackageId', null)"
                            class="px-8 py-4 font-bold transition-all bg-gray-100 text-dark rounded-2xl hover:bg-gray-200 active:scale-95">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
