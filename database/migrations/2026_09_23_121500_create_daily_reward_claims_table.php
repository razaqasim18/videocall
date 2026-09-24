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
        Schema::create('daily_reward_claims', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('daily_reward_id');

            $table->foreign('daily_reward_id')
                ->references('id')
                ->on('daily_rewards')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamp('claimed_at')->useCurrent();

            $table->timestamps();

            // Prevent the same user from claiming
            // the same daily reward more than once.
            $table->unique(
                ['user_id', 'daily_reward_id'],
                'user_daily_reward_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reward_claims');
    }
};
