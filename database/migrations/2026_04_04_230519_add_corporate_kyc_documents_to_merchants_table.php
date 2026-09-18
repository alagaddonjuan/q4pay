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
            // Adding the 8 missing corporate document paths
            $table->string('scuml_certificate_path')->nullable()->after('utility_bill_path');
            $table->string('proof_of_address_path')->nullable()->after('scuml_certificate_path');
            $table->string('memart_path')->nullable()->after('proof_of_address_path');
            $table->string('tin_certificate_path')->nullable()->after('memart_path');
            $table->string('cac_status_report_path')->nullable()->after('tin_certificate_path');
            $table->string('board_resolution_path')->nullable()->after('cac_status_report_path');
            $table->string('director_passport_path')->nullable()->after('board_resolution_path');
            $table->string('director_id_front_path')->nullable()->after('director_passport_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchants', function (Blueprint $table) {
            // Drop them if we ever need to rollback
            $table->dropColumn([
                'scuml_certificate_path',
                'proof_of_address_path',
                'memart_path',
                'tin_certificate_path',
                'cac_status_report_path',
                'board_resolution_path',
                'director_passport_path',
                'director_id_front_path'
            ]);
        });
    }
};
