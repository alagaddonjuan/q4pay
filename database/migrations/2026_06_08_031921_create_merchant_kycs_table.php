<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_kycs', function (Blueprint $table) {
            $table->id();
            // Link this KYC record to the specific Merchant in the 'merchants' table
            $table->foreignId('user_id')->constrained('merchants')->onDelete('cascade'); 
            
            // Business Info
            $table->string('business_name');
            $table->string('business_type');
            $table->string('registration_number');
            $table->string('tax_id');
            $table->string('industrial_sector');
            $table->text('business_address');
            
            // Director Info
            $table->string('rep_first_name');
            $table->string('rep_last_name');
            $table->string('rep_bvn');
            $table->string('rep_nin');
            $table->date('rep_dob');
            
            // Document Paths (Nullable in case a file upload fails, though our controller requires them)
            $table->string('cac_certificate_path')->nullable();
            $table->string('utility_bill_path')->nullable();
            $table->string('rep_id_card_path')->nullable();
            
            // Admin Status tracking
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_kycs');
    }
};