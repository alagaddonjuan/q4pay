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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            // Link it to the specific transaction and merchant
            $table->string('transaction_reference');
            $table->foreignId('merchant_id')->nullable()->constrained()->nullOnDelete();
            
            // The complaint and status
            $table->string('reason');
            $table->string('status')->default('open'); // open, investigating, resolved, rejected
            
            // For the CEO to leave a legal trail of how it was solved
            $table->text('resolution_notes')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};
