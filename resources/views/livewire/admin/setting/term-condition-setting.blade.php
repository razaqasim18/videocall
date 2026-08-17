<div class="space-y-8">
    <!-- Summernote Styles -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor.note-frame {
            border: 1px solid rgba(var(--primary-rgb), 0.1) !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            box-shadow: none !important;
        }

        .note-toolbar {
            background-color: #fcfcfd !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        .note-editing-area {
            background-color: white !important;
            font-family: inherit !important;
        }
    </style>

    <!-- Header -->
    <!-- Header -->
    <div class="space-y-8">
        <!-- Header Section -->
        <x-header-section headerwprimary="Term &" headerwsecondary="Condition"
            tagline="Define Term & Condition Policy information." />
    </div>
    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>

    <form wire:submit.prevent="saveSettings" class="grid grid-cols-1 gap-8">
        <!-- MAIN EDITOR COLUMN -->
        <div class="space-y-6">
            <div class="p-8 border shadow-sm bg-surface rounded-3xl border-primary/10">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-dark">Policy Content</h2>
                </div>

                <div class="space-y-4">
                    <!-- THE TEXT EDITOR -->
                    <div>
                        <label class="block mb-2 text-sm font-bold text-dark">Terms & Conditions Content</label>
                        <!-- wire:ignore is mandatory so Livewire doesn't overwrite the editor DOM -->
                        <div wire:ignore class="prose max-w-none">
                            <textarea id="summernote_terms"></textarea>
                        </div>
                        @error('term_condition_policy')
                            <span class="block text-sm text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tip Box -->
                    <div class="p-4 border border-blue-100 bg-blue-50/50 rounded-2xl">
                        <div class="flex gap-3">
                            <x-heroicon-o-information-circle class="w-5 h-5 text-blue-500" />
                            <p class="text-xs leading-relaxed text-blue-600">
                                <strong class="font-bold">Tip:</strong> Clearly define user responsibilities, payment
                                terms, and termination clauses. Using bullet points for "Rules of Conduct" makes the
                                document easier to navigate.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" wire:loading.attr="disabled"
                        class="flex items-center justify-center w-full gap-2 py-4 font-bold text-white transition-all transform bg-gradient-to-r from-primary to-secondary rounded-2xl hover:shadow-xl hover:shadow-primary/30 hover:-translate-y-1 disabled:opacity-70">
                        <span wire:loading.remove wire:target="saveSettings">Save Policy</span>
                        <span wire:loading wire:target="saveSettings">Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Summernote Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            const initSummernote = () => {
                const $el = $('#summernote_terms');
                if ($el.length === 0) return;

                $el.summernote({
                    height: 500,
                    callbacks: {
                        onChange: function(contents) {
                            // Syncs JS editor content to Livewire PHP property 'term_condition_policy'
                            @this.set('term_condition_policy', contents);
                        }
                    }
                });

                // Set initial value from Livewire property
                $el.summernote('code', @json($term_condition_policy ?? ''));
            };

            // Initial load delay to ensure DOM is ready
            setTimeout(initSummernote, 200);
        });
    </script>
</div>
