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
        Schema::create('message_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')
                ->constrained('messages')
                ->cascadeOnDelete();

            // Attachment type: image, video, audio, file, etc.
            $table->string('type', 20);

            // File storage details
            $table->string('file_path');
            $table->string('file_name');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->nullable(); // bytes

            // Optional thumbnail for videos/images
            $table->string('thumbnail_path')->nullable();

            // Flexible metadata: dimensions, duration, encoding, etc.
            $table->json('metadata')->nullable();

            $table->timestamps();

            // Fetch all attachments for a message
            $table->index('message_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_attachments');
    }
};
