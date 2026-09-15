<div class="relative flex items-center justify-center min-h-screen p-4 overflow-hidden bg-background">
    <div class="absolute top-0 rounded-full -left-20 w-96 h-96 bg-primary/10 blur-3xl"></div>
    <div class="absolute bottom-0 rounded-full -right-20 w-96 h-96 bg-secondary/10 blur-3xl"></div>

    <div class="relative z-10 w-full max-w-md">
        <div class="relative p-8 overflow-hidden border border-gray-200 shadow-sm bg-surface md:p-10 rounded-3xl">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary to-secondary"></div>

            <div class="mb-8 text-center">
                <h1 class="mb-2 text-3xl font-bold text-dark">Set a new password</h1>
                <p class="text-sm text-dark/60">Choose a strong password for your admin account.</p>
            </div>

            <form wire:submit.prevent="resetPassword" class="space-y-5">
                <div>
                    <label class="block mb-2 text-sm font-medium text-dark/80">Email Address</label>
                    <input type="email" wire:model.defer="email"
                        class="w-full py-3 pr-4 transition-all border border-gray-300 outline-none bg-background rounded-xl px-4 text-dark focus:border-primary focus:ring-1 focus:ring-primary">
                    @error('email')
                        <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-dark/80">New Password</label>
                    <input type="password" wire:model.defer="password"
                        class="w-full py-3 pr-4 transition-all border border-gray-300 outline-none bg-background rounded-xl px-4 text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                        placeholder="At least 8 characters">
                    @error('password')
                        <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-dark/80">Confirm Password</label>
                    <input type="password" wire:model.defer="password_confirmation"
                        class="w-full py-3 pr-4 transition-all border border-gray-300 outline-none bg-background rounded-xl px-4 text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                        placeholder="Repeat your password">
                    @error('password_confirmation')
                        <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Update password</span>
                    <span wire:loading>Updating...</span>
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('admin.login') }}" class="text-sm font-medium transition-colors text-primary hover:text-secondary">Return to sign in</a>
            </div>
        </div>
    </div>
</div>
