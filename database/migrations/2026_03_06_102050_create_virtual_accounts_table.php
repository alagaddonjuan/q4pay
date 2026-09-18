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
        Schema::create('virtual_accounts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('agent_id')->constrained('agents')->onDelete('cascade');
        $table->string('account_number')->unique(); 
        $table->string('bank_name')->default('9PSB');
        $table->string('customer_id'); 
        $table->string('order_ref'); 
        $table->decimal('ledger_balance', 15, 2)->default(0.00); 
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_accounts');
    }
};
