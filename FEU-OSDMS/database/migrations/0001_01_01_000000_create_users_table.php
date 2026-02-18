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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('id_number')->unique()->nullable(); // Student Number or Employee ID
            $table->string('role')->default('student'); // 'admin', 'guard', 'student'
            $table->string('program_code')->nullable(); // Matches NetSuite "PROGRAM" (e.g., BSIT)
            $table->string('campus')->default('Manila'); // Matches NetSuite "CAMPUS"
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
