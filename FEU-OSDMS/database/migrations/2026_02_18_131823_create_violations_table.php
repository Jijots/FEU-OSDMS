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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('reporter_id'); // Who reported it (Guard/Admin)
            $table->string('offense_type'); // e.g., "Improper Uniform"
            $table->text('description')->nullable();

            // NetSuite Specific Fields
            $table->text('findings')->nullable();       // "FINDINGS" box
            $table->text('recommendation')->nullable(); // "RECOMMENDATION" box
            $table->text('final_action')->nullable();   // "FINAL ACTION" box
            $table->string('academic_term')->nullable();

            $table->string('status')->default('Pending'); // Pending, Resolved
            $table->timestamps();

            // Foreign Key
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};
