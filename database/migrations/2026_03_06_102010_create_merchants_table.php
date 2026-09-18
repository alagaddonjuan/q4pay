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
        Schema::create('merchants', function (Blueprint $table) {
        $table->id();
        $table->string('business_name'); // e.g., "Modern Lottery"
        $table->string('q4i_api_key')->unique(); // The key Q4I gives to the merchant
        $table->string('contact_email');
        $table->decimal('wallet_balance', 15, 2)->default(0.00); // Merchant's total holding
        $table->string('webhook_url')->nullable(); // Where Q4I sends payment alerts back to the merchant
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
