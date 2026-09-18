<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('kyc_status')->default('unverified')->after('password'); // unverified, verified, failed
            $table->string('bvn', 11)->nullable()->after('kyc_status');
            $table->string('kyc_verified_name')->nullable()->after('bvn'); // The official master name from Dojah
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['kyc_status', 'bvn', 'kyc_verified_name']);
        });
    }
};