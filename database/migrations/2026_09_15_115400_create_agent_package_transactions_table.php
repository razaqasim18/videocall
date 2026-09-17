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
        Schema::create('agent_package_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_package_id'); 
            $table->foreign('agent_package_id')
                ->references('id')
                ->on('agent_packages')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

                $table->unsignedBigInteger('agent_id'); 
            $table->foreign('agent_id')
                ->references('id')
                ->on('agents')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Changed 8,2 to 12,2 for safer financial limits
            $table->decimal('price', 12, 2)->default(0.00); 
            $table->integer('coins')->default(1);
            $table->text('proof')->nullable();
            
            // Using 'needs_revision' instead of 'require-changing'
            $table->enum('status', ['pending', 'approved', 'denied', 'needs_revision'])->default('pending');
            
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_package_transactions');
    }
};
