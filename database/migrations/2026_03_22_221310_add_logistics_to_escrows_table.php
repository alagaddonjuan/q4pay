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
        Schema::table('escrow_transactions', function (Blueprint $table) {
            $table->string('shipping_status')->default('pending')->after('status'); // pending, shipped, delivered
            $table->string('courier_name')->nullable()->after('shipping_status'); // e.g., Sendbox, Kwik, DHL
            $table->string('tracking_number')->nullable()->after('courier_name');
            $table->text('tracking_link')->nullable()->after('tracking_number');
        });
    }

    public function down(): void
    {
        Schema::table('escrow_transactions', function (Blueprint $table) {
            $table->dropColumn(['shipping_status', 'courier_name', 'tracking_number', 'tracking_link']);
        });
    }
};
