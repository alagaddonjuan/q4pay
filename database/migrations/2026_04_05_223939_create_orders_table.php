<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_ref')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // The Vendor
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('buyer_name');
            $table->string('buyer_phone');
            $table->decimal('amount', 12, 2);
            $table->string('status')->default('pending'); // pending, paid, completed, disputed
            $table->string('disposable_account')->nullable();
            $table->string('bank_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
