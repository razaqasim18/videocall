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
        Schema::create('agent_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id'); 
            $table->foreign('agent_id')
                ->references('id')
                ->on('agents')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->enum('type', ['credit', 'debit'])->default('credit');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_wallet_transactions');
    }
};
