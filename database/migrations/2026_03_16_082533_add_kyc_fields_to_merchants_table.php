<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            // Account Type & Status
            $table->enum('business_type', ['individual', 'corporate'])->default('individual')->after('email');
            $table->enum('kyc_status', ['pending', 'approved', 'rejected'])->default('pending')->after('business_type');
            
            // Identification
            $table->string('bvn', 11)->nullable()->after('kyc_status');
            $table->string('nin', 11)->nullable()->after('bvn');
            $table->string('cac_number')->nullable()->after('nin');
            $table->string('tin_number')->nullable()->after('cac_number');
            
            // Document File Paths (Where we save the uploads)
            $table->string('cac_document_path')->nullable()->after('tin_number');
            $table->string('utility_bill_path')->nullable()->after('cac_document_path');
            
            // VAS Feature Flags
            $table->boolean('vas_requested')->default(false)->after('utility_bill_path');
            $table->boolean('vas_approved')->default(false)->after('vas_requested');
        });
    }

    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn([
                'business_type', 'kyc_status', 'bvn', 'nin', 'cac_number', 
                'tin_number', 'cac_document_path', 'utility_bill_path', 
                'vas_requested', 'vas_approved'
            ]);
        });
    }
};