<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            // Only add BVN if it doesn't exist
            if (!Schema::hasColumn('agents', 'bvn')) {
                $table->string('bvn', 11)->nullable();
            }
            
            // Only add NIN if it doesn't exist
            if (!Schema::hasColumn('agents', 'nin')) {
                $table->string('nin', 11)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            // Only drop BVN if it exists
            if (Schema::hasColumn('agents', 'bvn')) {
                $table->dropColumn('bvn');
            }

            // Only drop NIN if it exists
            if (Schema::hasColumn('agents', 'nin')) {
                $table->dropColumn('nin');
            }
        });
    }
};