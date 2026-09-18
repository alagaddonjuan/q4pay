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
        Schema::table('merchants', function (Blueprint $table) {
            $table->string('fee_tier')->default('standard')->after('business_type')->comment('standard, pro, enterprise');
            $table->decimal('total_processed_volume', 20, 2)->default(0)->after('fee_tier')->comment('Used to automatically upgrade fee tiers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn(['fee_tier', 'total_processed_volume']);
        });
    }
};
