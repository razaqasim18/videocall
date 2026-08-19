<div>
    <div class="space-y-8">
        <x-header-section :headerwprimary="$isEdit ? 'Edit' : 'Create'" headerwsecondary="Reward"
            tagline="Set the coin payout values for your reward system." />
    </div>

    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>

    <form wire:submit.prevent="saveReward" class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- LEFT: Details Section -->
        <div class="space-y-6 lg:col-span-2">
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center justify-center w-10 h-10 bg-primary/10 rounded-xl text-primary">
                        <x-heroicon-o-gift class="w-6 h-6" />
                    </div>
                    <h2 class="text-xl font-bold text-dark">Reward Value Details</h2>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <!-- Mission Field -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-medium text-dark/70">Reward Mission</label>
                        <input type="text" wire:model="mission"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="e.g. Daily Login Bonus">
                        @error('mission')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Task Field -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Task</label>
                        <input type="text" wire:model="task"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="Specific task requirement">
                        @error('task')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Coin Field - FIXED wire:model from "coins" to "coin" -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-dark/70">Coin Payout</label>
                        <input type="number" wire:model="coin"
                            class="w-full px-4 py-3 border outline-none bg-background border-primary/10 rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="50">
                        @error('coin')
                            <span class="block text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Configuration Section -->
        <div class="space-y-6">
            <div class="sticky space-y-6 top-24">
                <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                    <h2 class="mb-6 text-lg font-bold text-dark">Configuration</h2>
                    <div class="space-y-6">
                        <div
                            class="flex items-center justify-between p-4 border bg-background rounded-2xl border-primary/10">
                            <div class="flex items-center gap-3">
                                <div
                                    class="flex items-center justify-center w-8 h-8 text-green-600 bg-green-100 rounded-lg">
                                    <x-heroicon-o-check-circle class="w-5 h-5" />
                                </div>
                                <div class="text-sm font-bold text-dark">Active Reward</div>
                            </div>
                            <input type="checkbox" wire:model="is_active"
                                class="w-5 h-5 rounded text-primary focus:ring-primary">
                        </div>
                    </div>
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">
                    <span wire:loading.remove wire:target="saveReward">{{ $isEdit ? 'Update' : 'Create' }} Reward</span>
                    <span wire:loading wire:target="saveReward">Processing...</span>
                </button>
            </div>
        </div>
    </form>
</div>
