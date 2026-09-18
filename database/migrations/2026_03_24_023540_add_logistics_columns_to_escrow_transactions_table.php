<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escrow_transactions', function (Blueprint $table) {
            // Stores the buyer's full physical address
            $table->text('delivery_address')->nullable()->after('item_description');
            
            // Stores the exact delivery cost returned by Shipbubble/Terminal Africa
            $table->decimal('shipping_fee', 10, 2)->default(0)->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('escrow_transactions', function (Blueprint $table) {
            $table->dropColumn(['delivery_address', 'shipping_fee']);
        });
    }
};
