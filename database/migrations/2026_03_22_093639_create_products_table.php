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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Links the product to the specific vendor
            $table->string('name'); // e.g., "Nike Sneakers"
            $table->decimal('price', 10, 2); // e.g., 40000.00
            $table->text('description')->nullable(); 
            $table->boolean('is_active')->default(true); // Allows vendors to hide out-of-stock items
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
