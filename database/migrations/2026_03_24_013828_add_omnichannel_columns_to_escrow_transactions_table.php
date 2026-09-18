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
        Schema::table('escrow_transactions', function (Blueprint $table) {
            // We default to 'whatsapp' so your existing historical orders don't break!
            $table->string('platform')->default('whatsapp')->after('buyer_phone');
            
            // This holds the Meta PSID/IGSID (which can be long, so we use string)
            $table->string('platform_sender_id')->nullable()->after('platform');
            
            // Optional but recommended: make buyer_phone nullable now, 
            // since IG/FB won't give us a phone number immediately.
            $table->string('buyer_phone')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('escrow_transactions', function (Blueprint $table) {
            $table->dropColumn(['platform', 'platform_sender_id']);
            
            // Revert buyer_phone back to required if we rollback
            $table->string('buyer_phone')->nullable(false)->change();
        });
    }
};
