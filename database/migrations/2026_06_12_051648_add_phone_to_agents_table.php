<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            // Safely add the phone column if it is missing
            if (!Schema::hasColumn('agents', 'phone')) {
                $table->string('phone', 20)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            if (Schema::hasColumn('agents', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};
