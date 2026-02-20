<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.php artisan migrate
     */
    public function up(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            // These are the missing forensic fields required for ID matching
            $table->string('student_name')->nullable()->after('item_category');
            $table->string('student_number')->nullable()->after('student_name');
            $table->string('course')->nullable()->after('student_number');
        });
    }

    public function down(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dropColumn(['student_name', 'student_number', 'course']);
        });
    }
};
