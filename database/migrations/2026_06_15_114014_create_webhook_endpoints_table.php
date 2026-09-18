<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('webhook_endpoints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id'); // Links to your merchants/users table
            $table->string('live_url')->nullable();
            $table->string('test_url')->nullable();
            $table->string('secret')->unique(); // The whsec_ string
            $table->timestamps();

            // If your merchants table is named 'users', change 'merchants' to 'users' below
            // $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_endpoints');
    }
};
