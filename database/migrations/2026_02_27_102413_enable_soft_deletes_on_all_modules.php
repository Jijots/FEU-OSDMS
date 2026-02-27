<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Lost & Found
        Schema::table('lost_items', function (Blueprint $table) {
            $table->softDeletes();
        });

        // 2. Incident Reports
        Schema::table('incident_reports', function (Blueprint $table) {
            $table->softDeletes();
        });

        // 3. Violations
        Schema::table('violations', function (Blueprint $table) {
            $table->softDeletes();
        });

        // 4. Gate Entries
        Schema::table('gate_entries', function (Blueprint $table) {
            $table->softDeletes();
        });

        // 5. Confiscated Items (Evidence Locker)
        Schema::table('confiscated_items', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('lost_items', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('incident_reports', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('violations', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('gate_entries', function (Blueprint $table) { $table->dropSoftDeletes(); });
        Schema::table('confiscated_items', function (Blueprint $table) { $table->dropSoftDeletes(); });
    }
};
