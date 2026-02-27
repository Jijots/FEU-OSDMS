<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('confiscated_items', function (Blueprint $table) {
            // Adds the photo column right after the description
            $table->string('photo_path')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('confiscated_items', function (Blueprint $table) {
            $table->dropColumn('photo_path');
        });
    }
};
