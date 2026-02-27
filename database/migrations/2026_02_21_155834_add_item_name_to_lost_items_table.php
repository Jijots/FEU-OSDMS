<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            // Safely add tracking_number if it's missing
            if (!Schema::hasColumn('lost_items', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('id');
            }

            // Safely add item_name if it's missing
            if (!Schema::hasColumn('lost_items', 'item_name')) {
                $table->string('item_name')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            if (Schema::hasColumn('lost_items', 'item_name')) {
                $table->dropColumn('item_name');
            }
            if (Schema::hasColumn('lost_items', 'tracking_number')) {
                $table->dropColumn('tracking_number');
            }
        });
    }
};
