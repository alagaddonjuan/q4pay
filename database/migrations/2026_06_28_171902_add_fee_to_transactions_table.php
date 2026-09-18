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
        // Safely check if the column exists before trying to add it
        if (!Schema::hasColumn('transactions', 'fee_charged')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->decimal('fee_charged', 15, 2)->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safely check if the column exists before trying to drop it
        if (Schema::hasColumn('transactions', 'fee_charged')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('fee_charged');
            });
        }
    }
};