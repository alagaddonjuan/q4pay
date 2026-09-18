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
        Schema::create('system_fees', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type')->comment('e.g., inflow_transfer, outflow_payout, vas_mtn');
            $table->string('fee_tier')->default('standard')->comment('standard, pro, enterprise');
            $table->decimal('provider_cost', 10, 4)->default(0)->comment('What 9PSB charges/pays Q4I');
            $table->string('provider_cost_type')->default('percentage')->comment('percentage or flat');
            $table->decimal('merchant_charge', 10, 4)->default(0)->comment('What Q4I charges the merchant (or discount for VAS)');
            $table->string('merchant_charge_type')->default('percentage')->comment('percentage, flat, or tiered');
            $table->decimal('cap_amount', 10, 2)->nullable()->comment('Maximum fee allowed');
            $table->unique(['transaction_type', 'fee_tier']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_fees');
    }
};
