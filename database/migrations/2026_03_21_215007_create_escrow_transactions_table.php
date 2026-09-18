<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escrow_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // Unique Q4I transaction ID
            
            // The Parties Involved
            $table->foreignId('vendor_id')->constrained('users'); 
$table->string('buyer_phone'); // CRUCIAL: Captured in the vendor's first message
$table->string('virtual_account_number'); // The NUBAN sent to the buyer in-chat
$table->string('virtual_account_bank');
            
            // The Financials
            $table->foreignId('virtual_account_id')->constrained('virtual_accounts'); // The dedicated NUBAN for this specific escrow
            $table->decimal('amount', 15, 2); // Total amount the buyer pays
            $table->decimal('q4i_fee', 15, 2)->default(0); // The 1.5% margin (calculated on release)
            
            // The Product & Logistics
            $table->string('item_description'); // e.g., "Nike Sneakers Size 42"
            $table->string('logistics_provider')->nullable(); // e.g., "Sendbox"
            $table->string('tracking_code')->nullable(); 
            
            // The State Machine (CRUCIAL)
            $table->enum('status', [
                'awaiting_funds',   // Link generated, waiting for buyer transfer
                'funded_locked',    // Buyer paid, funds safely in Q4I vault
                'in_transit',       // Sendbox rider picked it up
                'disputed',         // Buyer raised an issue (Resolution Center)
                'released',         // Success: 5-and-1 algorithm executed
                'refunded'          // Auto-Reversal back to buyer
            ])->default('awaiting_funds');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrow_transactions');
    }
};