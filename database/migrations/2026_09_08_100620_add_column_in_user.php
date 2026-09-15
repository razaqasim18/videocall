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
        Schema::table('users', function (Blueprint $table) {
            // Adding new columns in specific order
            $table->string('phone')->nullable()->after('profile_image');
            $table->date('dob')->nullable()->after('phone'); // Now it comes after phone
            $table->string('material_status')->nullable()->after('gender');
            $table->string('interest')->nullable()->after('gender');

            // Modifying existing columns
            $table->string('password')->nullable()->change();
            $table->enum('gender', ['male', 'female', 'other'])->default('male')->change();

            // Adding social login columns
            $table->string('provider_id')->nullable();
            $table->string('provider_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the columns we added
            $table->dropColumn(['phone', 'dob', 'provider_id', 'provider_name', 'interest', 'material_status']);

            // Revert the changes to existing columns
            // Note: Make sure these match your ORIGINAL migration settings
            $table->string('password')->nullable(false)->change();
            $table->boolean('gender')->default(0)->change();
        });
    }
};
