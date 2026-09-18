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
    // 1. Give every merchant their own negotiated pricing plan
    Schema::table('merchants', function (Blueprint $table) {
        $table->decimal('inbound_flat_fee', 10, 2)->default(5.00)->after('wallet_balance');
        $table->decimal('outbound_flat_fee', 10, 2)->default(18.00)->after('inbound_flat_fee');
    });

    // 2. Track exactly how much Q4I makes on every single transaction
    Schema::table('transactions', function (Blueprint $table) {
        $table->decimal('fee_charged', 10, 2)->default(0.00)->after('amount');
        $table->decimal('settled_amount', 15, 2)->nullable()->after('fee_charged'); // What the merchant actually gets
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('merchants', function (Blueprint $table) {
        $table->dropColumn(['inbound_flat_fee', 'outbound_flat_fee']);
    });

    Schema::table('transactions', function (Blueprint $table) {
        $table->dropColumn(['fee_charged', 'settled_amount']);
    });
}
};
