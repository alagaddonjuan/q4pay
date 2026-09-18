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
        Schema::table('merchant_team_members', function (Blueprint $table) {
            if (!Schema::hasColumn('merchant_team_members', 'two_factor_secret')) {
                $table->text('two_factor_secret')->nullable();
            }
            if (!Schema::hasColumn('merchant_team_members', 'two_factor_enabled')) {
                $table->boolean('two_factor_enabled')->default(false);
            }
            if (!Schema::hasColumn('merchant_team_members', 'notification_preferences')) {
                $table->json('notification_preferences')->nullable();
            }
            if (!Schema::hasColumn('merchant_team_members', 'profile_picture')) {
                $table->string('profile_picture')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_team_members', function (Blueprint $table) {
            if (Schema::hasColumn('merchant_team_members', 'two_factor_secret')) {
                $table->dropColumn('two_factor_secret');
            }
            if (Schema::hasColumn('merchant_team_members', 'two_factor_enabled')) {
                $table->dropColumn('two_factor_enabled');
            }
            if (Schema::hasColumn('merchant_team_members', 'notification_preferences')) {
                $table->dropColumn('notification_preferences');
            }
            if (Schema::hasColumn('merchant_team_members', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }
        });
    }
};
