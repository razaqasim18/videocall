<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')
                ->constrained('conversations')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Message type: text, image, video, link, file, audio, mixed
            $table->string('type', 20)->default('text');

            // Text content / caption — nullable since media-only messages need no body
            $table->longText('body')->nullable();

            // URL for link-type messages
            $table->string('url', 2048)->nullable();

            // Self-referencing FK for replies — nullOnDelete so replies survive parent deletion
            $table->foreignId('reply_to_message_id')
                ->nullable()
                ->constrained('messages')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            // Primary query: fetch messages for a conversation ordered by time
            $table->index(['conversation_id', 'created_at']);

            // Lookup messages by sender
            $table->index('user_id');

            // Lookup replies to a message
            $table->index('reply_to_message_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
