<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Adds the slug column, allowing it to be empty for older products
            $table->string('slug')->nullable()->unique(); 
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Safely removes it if we ever roll back
            $table->dropColumn('slug'); 
        });
    }
};
