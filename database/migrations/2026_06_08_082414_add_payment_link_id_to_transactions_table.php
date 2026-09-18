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
        Schema::table('transactions', function (Blueprint $table) {
            // Only add the column if it doesn't already exist!
            if (!Schema::hasColumn('transactions', 'payment_link_id')) {
                $table->foreignId('payment_link_id')->nullable()->constrained('payment_links')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Only drop the column if it exists!
        });
    }
};
