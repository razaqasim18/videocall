<div class="space-y-8">
    <!-- Header Section -->
    <div class="space-y-8">
        <x-header-section :headerwprimary="$isEdit ? 'Edit' : 'Create'" headerwsecondary="Gift"
            tagline="Manage virtual gifts, animations, and coin pricing for your platform." />
    </div>

    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>

    <form wire:submit.prevent="saveGift" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- LEFT: Gift Details -->
        <div class="space-y-6 lg:col-span-2">
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-o-gift class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Gift Details</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Gift Name -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-dark/70">Gift Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="e.g. Rose, Heart, Crown">
                        @error('name')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Coins -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Coin Price</label>
                        <input type="number" min="1" wire:model="coins"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="100">
                        @error('coins')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Animation Format -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Animation Format</label>
                        <select wire:model.live="animation_type"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                            <option value="gif">GIF</option>
                            <option value="lottie">Lottie JSON</option>
                        </select>
                        @error('animation_type')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- THE SMART UPLOAD/CDN SECTION -->
                    <div class="space-y-6 md:col-span-2">
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-semibold text-dark">Animation Source</span>
                            <div class="flex-1 h-px bg-primary/10"></div>
                        </div>

                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            <!-- Option A: Local Upload -->
                            <div class="space-y-3">
                                <label class="block text-xs font-bold tracking-wider uppercase text-dark/40">Option 1:
                                    Upload File</label>
                                <div
                                    class="relative flex flex-col items-center justify-center p-6 text-center transition border-2 border-dashed bg-background border-primary/20 rounded-2xl hover:border-primary/50 group">
                                    <x-heroicon-o-arrow-up-tray
                                        class="w-8 h-8 mb-2 transition-transform text-primary group-hover:scale-110" />
                                    <p class="text-xs font-semibold text-dark">Click to upload
                                        {{ $animation_type === 'gif' ? 'GIF' : 'JSON' }}</p>
                                    <input type="file" wire:model="animation_file"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </div>

                                @if ($animation_file)
                                    <div
                                        class="p-2 border rounded-xl bg-background border-primary/10 w-fit animate-pulse">
                                        @if ($animation_type === 'gif')
                                            <img src="{{ $animation_file->temporaryUrl() }}"
                                                class="object-contain w-20 h-20 rounded-lg">
                                        @else
                                            <div class="flex items-center gap-2 p-2">
                                                <x-heroicon-o-document-text class="w-5 h-5 text-primary" />
                                                <span
                                                    class="text-xs text-dark">{{ $animation_file->getClientOriginalName() }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                @error('animation_file')
                                    <span class="block text-xs text-red-600">{{ $message }}</span>
                                @enderror
                                <div wire:loading wire:target="animation_file" class="text-xs text-primary">Uploading...
                                </div>
                            </div>

                            <!-- Option B: CDN URL -->
                            <div class="space-y-3">
                                <label class="block text-xs font-bold tracking-wider uppercase text-dark/40">Option 2:
                                    CDN URL</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-primary/50">
                                        <x-heroicon-o-cloud class="w-5 h-5" />
                                    </div>
                                    <input type="url" wire:model="cdn_url"
                                        class="w-full px-4 py-3 border outline-none pl-11 bg-background border-primary/10 rounded-2xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder="https://cdn.example.com/gift.gif">
                                </div>
                                <p class="text-[11px] text-dark/50 italic">
                                    Note: If both are provided, the CDN URL will take priority.
                                </p>
                                @error('cdn_url')
                                    <span class="block text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Configuration -->
        <div class="space-y-6">
            <div class="sticky space-y-6 top-24">
                <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                    <h2 class="mb-6 text-lg font-bold text-dark">Configuration</h2>
                    <div class="space-y-6">
                        <!-- Active -->
                        <div
                            class="flex items-center justify-between p-4 border bg-background rounded-2xl border-primary/10">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-lg">
                                    <x-heroicon-o-check-circle class="w-5 h-5" />
                                </div>
                                <div class="text-sm font-bold text-dark">Active Gift</div>
                            </div>
                            <input type="checkbox" wire:model="is_active"
                                class="w-5 h-5 rounded text-primary focus:ring-primary">
                        </div>
                    </div>
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">
                    <span wire:loading.remove wire:target="saveGift">{{ $isEdit ? 'Update' : 'Create' }} Gift</span>
                    <span wire:loading wire:target="saveGift">Processing...</span>
                </button>
            </div>
        </div>
    </form>
</div>
