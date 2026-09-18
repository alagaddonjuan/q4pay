<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('live_webhook_url')->nullable();
            $table->string('test_webhook_url')->nullable();
            $table->string('webhook_secret')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['live_webhook_url', 'test_webhook_url', 'webhook_secret']);
        });
    }
};