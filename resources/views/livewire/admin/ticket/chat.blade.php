<div>
    @push('styles')
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
    @endpush

    <div id="successdiv">
        @if (session()->has('success'))
            <x-alert :message="session()->get('success')" status="1"></x-alert>
        @endif
        @if (session()->has('error'))
            <x-alert :message="session()->get('error')" status="0"></x-alert>
        @endif
    </div>

    <div class="min-h-screen p-4 md:p-8 bg-slate-50">

        <!-- STATUS BAR -->
        <div class="flex items-center justify-between p-4 mb-6 bg-white border shadow-sm rounded-2xl border-primary/10">
            <div class="flex items-center gap-3">
                <x-heroicon-o-ticket class="w-6 h-6 text-primary" />
                <div class="flex flex-col">
                    <h3 class="font-bold leading-none text-dark">{{ $ticket->subject }}</h3>
                    <span class="text-[10px] text-slate-400 uppercase font-bold">Ticket #{{ $ticket->ticket_no }}</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span
                    class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $ticket->status == 'open' ? 'bg-emerald-100 text-emerald-600' : ($ticket->status == 'resolved' ? 'bg-indigo-100 text-indigo-600' : 'bg-slate-100 text-slate-500') }}">
                    {{ $ticket->status }}
                </span>
            </div>
        </div>

        <!-- Original Ticket Message -->
        <div class="p-4 mb-6 bg-white border shadow-sm rounded-2xl border-primary/10">
            <div class="flex justify-start">
                <div class="w-full p-4 rounded-tl-none shadow-sm bg-slate-100 text-dark rounded-2xl">
                    <div class="text-[10px] opacity-70 mb-1 font-bold uppercase">
                        {{ $ticket->creator->name }}
                    </div>
                    <div class="mb-1 text-sm font-bold text-dark">{{ $ticket->subject }}</div>
                    <div class="text-sm prose-sm prose text-dark">
                        {!! $ticket->message !!}
                    </div>
                    <div class="text-[9px] mt-2 text-right opacity-50">
                        {{ $ticket->created_at->format('d M, h:i A') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="space-y-4 bg-white p-6 rounded-3xl border border-primary/10 shadow-sm min-h-[600px] flex flex-col">
            <div id="chat-window" class="flex-1 space-y-4 overflow-y-auto max-h-[60vh] pr-2">

                <!-- Ticket Replies -->
                @foreach ($ticket->replies->reverse() as $reply)
                    @php
                        // Determine if sender is internal staff
                        $isStaff = in_array($reply->senderable_type, ['App\Models\Admin', 'App\Models\Agent']);

                        // Determine label based on type
                        $senderLabel = match ($reply->senderable_type) {
                            'App\Models\Admin' => 'Admin',
                            'App\Models\Agent' => 'Agent',
                            default => $reply->senderable->name ?? 'User',
                        };
                    @endphp

                    <div class="flex {{ $isStaff ? 'justify-end' : 'justify-start' }}">
                        <div
                            class="max-w-md p-4 rounded-2xl shadow-sm {{ $isStaff ? 'bg-primary text-white rounded-tr-none' : 'bg-slate-100 text-dark rounded-tl-none' }}">

                            <div class="text-[10px] opacity-70 mb-1 font-bold uppercase">
                                {{ $senderLabel }}
                            </div>

                            <div class="text-sm prose prose-sm {{ $isStaff ? 'text-white' : 'text-dark' }}">
                                {!! $reply->message !!}
                            </div>

                            <div
                                class="text-[9px] mt-2 text-right opacity-50 {{ $isStaff ? 'text-white' : 'text-slate-500' }}">
                                {{ $reply->created_at->format('h:i A') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Reply Box -->
            <div class="pt-6 mt-6 border-t border-primary/5">
                <div class="flex flex-col gap-4">
                    <div wire:ignore>
                        <textarea id="summernote_create"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button wire:click="sendReply" wire:loading.attr="disabled"
                            class="flex items-center gap-2 px-6 py-3 font-bold text-white transition-all shadow-md bg-primary rounded-xl hover:bg-primary/90">
                            <span wire:loading.remove wire:target="sendReply">Send Message</span>
                            <span wire:loading wire:target="sendReply">Sending...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

        <script>
            Livewire.on('clear-summernote', () => {
                $('#summernote_create').summernote('code', '');
            });

            function initSummernoteReply() {
                const $el = $('#summernote_create');
                if ($el.length === 0) return;

                const componentElement = $el.closest('[wire\\:id]')[0];
                if (!componentElement) return;

                const component = Livewire.find(componentElement.getAttribute('wire:id'));

                if ($el.next('.note-editor').length) {
                    $el.summernote('destroy');
                }

                $el.summernote({
                    height: 150,
                    callbacks: {
                        onChange: function(contents) {
                            component.set('ticketmessage', contents);
                        }
                    }
                });
            }

            document.addEventListener('livewire:navigated', () => {
                setTimeout(initSummernoteReply, 200);
            });

            document.addEventListener('livewire:initialized', () => {
                setTimeout(initSummernoteReply, 200);
            });

            window.addEventListener('load', () => {
                initSummernoteReply();
            });
        </script>
    @endpush
</div>
