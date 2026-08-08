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
                <h1 class="mb-2 text-3xl font-bold text-dark">Welcome <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-secondary">Admin</span>
                </h1>
                <p class="text-sm text-dark/60">Please enter your details to sign in to your account</p>
            </div>

            @if (session('status'))
                <div class="p-4 mb-6 text-green-700 border border-green-200 rounded-xl bg-green-50">
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit.prevent="login" class="space-y-5">
                <!-- Email Field -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-dark/80">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <x-heroicon-o-envelope class="w-5 h-5 text-dark/40" />
                        </span>
                        <input type="email" wire:model="email"
                            class="w-full py-3 pr-4 transition-all border border-gray-300 outline-none bg-background rounded-xl pl-11 text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="name@example.com">
                    </div>
                    @error('email')
                        <span class="block mt-1 text-xs text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex justify-between mb-2">
                        <label class="text-sm font-medium text-dark/80">Password</label>
                        <a href="{{ route('admin.forget-password') }}"
                            class="text-xs font-medium transition-colors text-primary hover:text-secondary">Forgot
                            Password?</a>
                    </div>
                    <div class="relative" x-data="{ show: false }">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <x-heroicon-o-lock-closed class="w-5 h-5 text-dark/40" />
                        </span>
                        <input x-bind:type="show ? 'text' : 'password'" wire:model.defer="password"
                            autocomplete="current-password"
                            class="w-full py-3 pr-12 transition-all border border-gray-300 outline-none bg-background rounded-xl pl-11 text-dark focus:border-primary focus:ring-1 focus:ring-primary"
                            placeholder="••••••••" />
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

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" wire:model="remember"
                            class="w-4 h-4 border-gray-300 rounded text-primary focus:ring-primary">
                        <span class="text-sm transition-colors text-dark/70 group-hover:text-dark">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button (Matching your Contact Form) -->
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-gradient-to-r from-primary to-secondary text-white font-bold py-3.5 rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    <span wire:loading.remove>Sign In</span>
                    <span wire:loading>Signing in...</span>

                </button>
            </form>
            <div class="mt-6 text-center">
                <a href="/" class="text-sm font-medium transition-colors text-primary hover:text-secondary">Back
                    to sign in</a>
            </div>

            <!-- Footer -->
            {{-- <div class="mt-8 text-center">
                <p class="text-sm text-dark/60">
                    Don't have an account?
                    <a href="/register"
                        class="font-semibold transition-colors text-primary hover:text-secondary">Create an account</a>
                </p>
            </div> --}}
        </div>


    </div>
</div>
