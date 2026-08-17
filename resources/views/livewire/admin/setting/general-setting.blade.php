<div class="space-y-8">
    <!-- Header -->
    <div class="space-y-8">
        <!-- Header Section -->
        <x-header-section headerwprimary="Website" headerwsecondary="Setting"
            tagline="Manage your global brand identity, contact details, and site appearance." />
    </div>
    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>

    <form wire:submit.prevent="saveSettings" class="grid grid-cols-1 gap-8 lg:grid-cols-3">

        <!-- LEFT COLUMN: General Configuration -->
        <div class="space-y-6 lg:col-span-2">

            <!-- Section 1: Site Identity -->
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-o-globe-alt class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Site Identity</h2>
                </div>

                <div class="space-y-6">
                    <!-- App Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Site Name</label>
                        <input type="text" wire:model="site_name"
                            class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="e.g. FitFlow Gym Network">
                        @error('site_name')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Short Description </label>
                        <textarea wire:model="short_description" rows="3"
                            class="w-full px-4 py-3 transition-all border outline-none resize-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Describe your business in one or two sentences..."></textarea>
                        @error('short_description')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Contact & Support -->
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 text-secondary bg-secondary/10 rounded-xl">
                        <x-heroicon-o-map-pin class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Contact Information</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Official Email</label>
                        <input type="email" wire:model="email"
                            class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="support@brand.com">
                        @error('email')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Contact Phone</label>
                        <input type="tel" wire:model="phone"
                            class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="+92 300 1234567">
                        @error('phone')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-dark/70">Physical Address</label>
                        <textarea wire:model="address" rows="2"
                            class="w-full px-4 py-3 transition-all border outline-none resize-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Street, City, Country"></textarea>
                        @error('address')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 4: Agent Commission Settings -->
            <div class="p-8 mt-6 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 text-secondary bg-secondary/10 rounded-xl">
                        <!-- Using currency-dollar icon for commission -->
                        <x-heroicon-o-currency-dollar class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Agent Commission Settings</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Commission Type -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Commission Type</label>
                        <select id="agent_commission_type" wire:model="agent_commission_type"
                            class="w-full px-4 py-3 transition-all border outline-none appearance-none cursor-pointer bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="">Select Type</option>
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                        @error('agent_commission_type')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Commission Value -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">
                            {{-- Dynamic Label: Changes based on selected type --}}
                            {{ $this->agent_commission_type == 'percentage' ? 'Percentage Value (%)' : ($this->agent_commission_type == 'fixed' ? 'Fixed Amount' : 'Commission Value') }}
                        </label>
                        <div class="relative">
                            <input type="number" wire:model="agent_commission_amount" step="0.01"
                                class="w-full px-4 py-3 transition-all border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                                placeholder="{{ $this->agent_commission_type == 'percentage' ? 'e.g. 5' : 'e.g. 500' }}">

                            <!-- Optional: Visual hint icon inside the input -->
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-sm pointer-events-none text-dark/40">
                                {{ $this->agent_commission_type == 'percentage' ? '%' : '$.' }}
                            </div>
                        </div>
                        @error('agent_commission_amount')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>



        </div>

        <!-- RIGHT COLUMN: Visual Assets & Action -->
        <div class="space-y-6">
            <div class="sticky top-24">
                <!-- Logo Card -->
                <div class="p-8 mb-4 text-center border shadow-sm bg-surface rounded-3xl border-primary/10">
                    <h2 class="mb-6 text-lg font-bold text-dark">Website Logo</h2>

                    <div class="relative inline-block group">
                        <!-- Logo Container (Rectangular) -->
                        <div
                            class="relative w-full h-32 overflow-hidden transition-all border-2 border-dashed rounded-2xl bg-background ring-4 ring-primary/5 group-hover:border-primary/50">
                            @if ($temlogo && is_object($temlogo))
                                <img src="{{ $temlogo->temporaryUrl() }}" class="object-contain w-full h-full p-2">
                            @elseif ($logo != null)
                                <img src="{{ asset('/storage/' . $logo) }}" class="object-contain w-full h-full p-2">
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-dark/30">
                                    <x-heroicon-o-photo class="w-10 h-10 mb-2" />
                                    <span class="text-xs">No Logo Uploaded</span>
                                </div>
                            @endif

                            <div
                                class="absolute inset-0 flex items-center justify-center transition-opacity opacity-0 cursor-pointer bg-black/20 group-hover:opacity-100">
                                <x-heroicon-o-camera class="w-8 h-8 text-white" />
                            </div>
                        </div>

                        <label
                            class="absolute bottom-0 right-0 p-2 text-white transition-all border-2 border-white rounded-full shadow-lg cursor-pointer bg-primary hover:bg-primary/90 group-hover:scale-110">
                            <x-heroicon-o-arrow-up-on-square-stack class="w-5 h-5" />
                            <input type="file" wire:model="temlogo" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <br />
                    <div wire:loading wire:target="temlogo" class="mt-4 text-center">
                        <br />
                        <p class="text-xs font-medium text-primary animate-pulse">Uploading logo...</p>
                    </div>
                    <p class="mt-4 text-[11px] text-dark/40">Recommended size: 512x512px (PNG/JPG)</p>
                </div>

                <!-- Favicon Card -->
                <div class="p-8 mb-2 text-center border shadow-sm bg-surface rounded-3xl border-primary/10">
                    <h2 class="mb-6 text-lg font-bold text-dark">Browser Favicon</h2>

                    <div class="relative inline-block group">
                        <!-- Favicon Container (Small Square) -->
                        <div
                            class="relative w-20 h-20 mx-auto overflow-hidden transition-all border-2 border-dashed rounded-xl bg-background ring-4 ring-primary/5 group-hover:border-primary/50">
                            @if ($temfavicon && is_object($temfavicon))
                                <img src="{{ $temfavicon->temporaryUrl() }}" class="object-cover w-full h-full">
                            @elseif ($favicon)
                                <img src="{{ asset('/storage/' . $favicon) }}" class="object-cover w-full h-full">
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-dark/30">
                                    <x-heroicon-o-photo class="w-10 h-10 mb-2" />
                                    <span class="text-xs">No Icon Uploaded</span>
                                </div>
                            @endif

                            <div
                                class="absolute inset-0 flex items-center justify-center transition-opacity opacity-0 cursor-pointer bg-black/20 group-hover:opacity-100">
                                <x-heroicon-o-camera class="w-6 h-6 text-white" />
                            </div>
                        </div>

                        <label
                            class="absolute bottom-0 right-0 p-2 text-white transition-all border-2 border-white rounded-full shadow-lg cursor-pointer bg-primary hover:bg-primary/90 group-hover:scale-110">
                            <x-heroicon-o-arrow-up-on-square-stack class="w-4 h-4" />
                            <input type="file" wire:model="temfavicon" class="hidden" accept="image/*">
                        </label>
                    </div>
                    <br />
                    <div wire:loading wire:target="temfavicon" class="mt-4 text-center ">
                        <p class="text-xs font-medium text-primary animate-pulse">Uploading favicon...</p>
                    </div>
                    <p class="mt-4 text-[11px] text-dark/40">Recommended size: 32x32px (ICO/PNG)</p>
                </div>

                <!-- Save Action -->
                <div class="p-2">
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">

                        <span wire:loading.remove wire:target="saveSettings">
                            Save Website Settings
                        </span>

                        <span wire:loading wire:target="saveSettings">
                            Saving Changes...
                        </span>
                    </button>
                </div>
            </div>
        </div>

    </form>
    <script>
        const typeElement = document.getElementById('agent_commission_type');
        typeElement.addEventListener('change', function() {
            const selectedValue = this.value;
            @this.set('agent_commission_type', selectedValue);
        });
    </script>
</div>
