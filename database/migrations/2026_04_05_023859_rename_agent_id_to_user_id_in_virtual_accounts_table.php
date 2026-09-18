<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('virtual_accounts', function (Blueprint $table) {
            // 1. Drop the old foreign key constraint (if you had one)
            // Note: The constraint name is usually table_column_foreign
            $table->dropForeign(['agent_id']); 
            
            // 2. Rename the column
            $table->renameColumn('agent_id', 'user_id');

            // 3. Add the new foreign key pointing to the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('virtual_accounts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'agent_id');
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });
    }
};
