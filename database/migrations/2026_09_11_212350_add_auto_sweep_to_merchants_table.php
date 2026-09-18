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
            $table->boolean('auto_sweep_enabled')->default(false);
            $table->string('auto_sweep_frequency')->default('daily'); 
            $table->decimal('auto_sweep_threshold', 15, 2)->nullable();
            $table->unsignedBigInteger('auto_sweep_bank_account_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn([
                'auto_sweep_enabled', 
                'auto_sweep_frequency', 
                'auto_sweep_threshold', 
                'auto_sweep_bank_account_id'
            ]);
        });
    }
};
