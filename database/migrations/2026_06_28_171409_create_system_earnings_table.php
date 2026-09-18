<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('system_earnings', function (Blueprint $table) {
        $table->id();
        $table->string('transaction_ref');
        $table->unsignedBigInteger('merchant_id')->nullable();
        $table->string('type'); // e.g., 'inflow_fee' or 'outflow_fee'
        $table->decimal('amount', 15, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_earnings');
    }
};
