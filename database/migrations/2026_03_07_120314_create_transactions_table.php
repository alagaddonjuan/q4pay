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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('virtual_account_id')->constrained()->onDelete('cascade');
        $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
        $table->string('session_id')->unique(); // The bank's unique receipt number
        $table->string('type')->default('credit'); // 'credit' or 'debit'
        $table->decimal('amount', 15, 2);
        $table->decimal('balance_before', 15, 2);
        $table->decimal('balance_after', 15, 2);
        $table->string('status')->default('successful');
        $table->text('remarks')->nullable(); // e.g., "Payment for shoes"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
