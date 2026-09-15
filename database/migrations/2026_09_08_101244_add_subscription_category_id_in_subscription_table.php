<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // STEP 1: Add the column as nullable first, WITHOUT the constrained() method
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_category_id')->nullable()->after('id');
        });

        // STEP 2: Ensure at least one category exists with ID 1
        // This prevents the foreign key error.
        DB::table('subscription_categories')->insertGetId([
            'name' => 'Default Category', // Give it a name
        ]);

        // Note: If you already have categories, you can skip the insert
        // but ensure a record with ID 1 exists.

        // STEP 3: Update existing rows to use ID 1
        DB::table('subscriptions')->update([
            'subscription_category_id' => 1,
        ]);

        // STEP 4: Now add the Foreign Key constraint and make it non-nullable
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_category_id')->change(); // Make it non-nullable if desired
            $table->foreign('subscription_category_id')
                ->references('id')
                ->on('subscription_categories')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['subscription_category_id']);
            $table->dropColumn('subscription_category_id');
        });
    }
};
