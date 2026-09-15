<div class="relative flex items-center justify-center min-h-screen p-4 overflow-hidden bg-background">
    <!-- Background Decorative Elements (Matching your Contact Page style) -->
    <div class="absolute top-0 rounded-full -left-20 w-96 h-96 bg-primary/10 blur-3xl"></div>
    <div class="absolute bottom-0 rounded-full -right-20 w-96 h-96 bg-secondary/10 blur-3xl"></div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Login Card -->
        <div class="relative p-8 overflow-hidden border border-gray-200 shadow-sm bg-surface md:p-10 rounded-3xl">

            <!-- Top Accent Gradient Line -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary to-secondary"></div>

            <div class="mb-8 text-center">
                <h1 class="mb-2 text-3xl font-bold text-dark">Update <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Password</span>
                </h1>
                <p class="text-sm text-dark/60">
                    Please choose a strong password to keep your account secure.
                </p>
            </div>

            @if (session()->has('success'))
                <x-alert class="mb-6" status="1" :message="session()->get('success')"></x-alert>
            @endif
            @if (session()->has('error'))
                <x-alert class="mb-6" status="0" :message="session()->get('error')"></x-alert>
            @endif
            <!-- Form -->
            <form wire:submit.prevent="updatePassword" class="space-y-6">

                <!-- New Password Field -->
                <div class="relative group">
                    <label class="block mb-2 text-sm font-medium text-dark/80">New Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-dark/40">
                            <x-heroicon-o-lock-closed class="w-5 h-5" />
                        </span>
                        <input x-bind:type="show ? 'text' : 'password'" wire:model="password"
                            class="w-full py-3 pr-4 transition-all border border-gray-300 outline-none pl-11 bg-background rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 transition-colors text-dark/40 hover:text-primary">
                            <!-- Eye Icon -->
                            <x-heroicon-o-eye-slash x-show="!show" class="w-5 h-5" />
                            <x-heroicon-o-eye x-show="show" class="w-5 h-5" />
                        </button>
                    </div>
                    @error('password')
                        <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="relative group">
                    <label class="block mb-2 text-sm font-medium text-dark/80">Confirm New Password</label>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-dark/40">
                            <x-heroicon-o-lock-closed class="w-5 h-5" />
                        </span>
                        <input x-bind:type="show ? 'text' : 'password'" wire:model="password_confirmation"
                            class="w-full py-3 pr-4 transition-all border border-gray-300 outline-none pl-11 bg-background rounded-xl text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="••••••••">
                        <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 transition-colors text-dark/40 hover:text-primary">
                            <!-- Eye Icon -->
                            <x-heroicon-o-eye-slash x-show="!show" class="w-5 h-5" />
                            <x-heroicon-o-eye x-show="show" class="w-5 h-5" />
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Requirement Tip -->
                <div class="p-4 border bg-primary/5 border-primary/10 rounded-2xl">
                    <div class="flex gap-3">
                        <x-heroicon-o-lock-closed class="w-5 h-5" />
                        <p class="text-xs leading-relaxed text-dark/60">
                            For better security, use a mix of <span class="font-bold text-dark">uppercase letters,
                                numbers, and
                                special characters</span>.
                        </p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all transform hover:-translate-y-0.5 active:scale-95">
                    <span wire:loading.attr='hidden' wire:target="updatePassword">Update Password</span>
                    <span wire:loading wire:target="updatePassword">Updating Password...</span>
                </button>
            </form>
        </div>
    </div>
</div>
