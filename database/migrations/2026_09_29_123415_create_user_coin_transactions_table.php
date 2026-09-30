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
        Schema::create('user_coin_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // credit / debit
            $table->enum('status', [
                'credit',
                'debit',
            ]);

            // call, gift, daily_reward, package_purchase, etc.
            $table->string('type');

            // Amount of coins involved
            $table->unsignedInteger('coins');

            // Balance before and after transaction
            $table->unsignedInteger('coin_before');
            $table->unsignedInteger('coin_after');

            $table->text('description')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coin_transactions');
    }
};
