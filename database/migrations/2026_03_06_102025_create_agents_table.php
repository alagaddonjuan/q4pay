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
        Schema::create('agents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade'); // Links to Q4I Merchant
        $table->string('merchant_reference')->nullable(); // The merchant's internal ID for this user
        $table->string('first_name');
        $table->string('last_name'); 
        $table->string('phone_number')->unique(); 
        $table->string('email')->nullable();
        $table->string('bvn')->unique(); 
        $table->string('date_of_birth'); 
        $table->integer('gender')->default(0); 
        $table->text('address')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
