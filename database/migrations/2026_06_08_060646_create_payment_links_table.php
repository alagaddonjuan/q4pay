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
    Schema::create('payment_links', function (Blueprint $table) {
        $table->id();
        $table->foreignId('merchant_id')->constrained('merchants');
        $table->string('title');
        $table->decimal('amount', 15, 2);
        $table->string('reference')->unique(); // The unique URL slug
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_links');
    }
};
