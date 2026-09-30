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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();

            $table->foreignId('caller_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('calle_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedInteger('duration')->default(0);

            $table->timestamp('call_start')->nullable();
            $table->timestamp('call_end')->nullable();

            $table->enum('status', [
                'calling',
                'connected',
                'ended',
                'rejected',
                'missed',
            ])->default('calling');

            $table->string('end_reason')->nullable();

            $table->timestamps();

            $table->index('caller_id');
            $table->index('calle_id');
            $table->index('status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
