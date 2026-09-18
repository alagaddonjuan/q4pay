<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Upgrade the existing Products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name'); // e.g., Electronics, Fashion
            $table->integer('stock')->default(1)->after('price'); // How many are available
            $table->integer('sold')->default(0)->after('stock'); // How many have been bought
        });

        // 2. Create the new Withdrawals table for the Wallet System
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name')->nullable();
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'stock', 'sold']);
        });
    }
};
