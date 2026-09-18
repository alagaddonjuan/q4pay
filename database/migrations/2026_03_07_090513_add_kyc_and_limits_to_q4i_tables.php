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
    // 1. Upgrade the Agents Table (Ready for AI & KYC)
    Schema::table('agents', function (Blueprint $table) {
        $table->integer('kyc_tier')->default(1)->after('bvn'); // Tier 1 because they have a BVN
        $table->string('id_document_url')->nullable()->after('kyc_tier'); // Where we will save the ID for the AI to read
        $table->decimal('liveness_score', 5, 2)->nullable()->after('id_document_url'); // The AI confidence score (e.g., 98.50%)
    });

    // 2. Upgrade the Virtual Accounts Table (Ready for Limits & Freezes)
    Schema::table('virtual_accounts', function (Blueprint $table) {
        $table->string('wallet_status')->default('active')->after('is_active'); // 'active', 'frozen_by_ai', 'restricted'
        $table->decimal('daily_transfer_limit', 15, 2)->default(50000.00)->after('ledger_balance'); // CBN Tier 1 Limit
        $table->decimal('max_balance_limit', 15, 2)->default(300000.00)->after('daily_transfer_limit'); // CBN Tier 1 Limit
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    // This allows you to undo the changes if you ever make a mistake
    Schema::table('agents', function (Blueprint $table) {
        $table->dropColumn(['kyc_tier', 'id_document_url', 'liveness_score']);
    });

    Schema::table('virtual_accounts', function (Blueprint $table) {
        $table->dropColumn(['wallet_status', 'daily_transfer_limit', 'max_balance_limit']);
    });
}
};
