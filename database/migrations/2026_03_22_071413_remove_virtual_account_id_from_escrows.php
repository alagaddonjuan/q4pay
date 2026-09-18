<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escrow_transactions', function (Blueprint $table) {
            // Drop the strict foreign key rule first
            $table->dropForeign(['virtual_account_id']);
            // Then drop the column completely
            $table->dropColumn('virtual_account_id');
        });
    }

    public function down(): void
    {
        Schema::table('escrow_transactions', function (Blueprint $table) {
            $table->foreignId('virtual_account_id')->nullable()->constrained('virtual_accounts');
        });
    }
};