<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('confiscated_items', function (Blueprint $table) {
            $table->id();

            // The Chain of Custody Data
            $table->string('student_id')->nullable(); // ID of the student it was taken from
            $table->string('item_name'); // e.g., Vape, Unregistered ID, Contraband
            $table->text('description')->nullable();
            $table->string('confiscated_by'); // Name of the officer who seized it
            $table->date('confiscated_date');
            $table->string('storage_location')->nullable(); // e.g., Evidence Locker A, Box 3

            // Status Tracking
            $table->enum('status', ['Safekeeping', 'Returned', 'Disposed'])->default('Safekeeping');
            $table->text('resolution_notes')->nullable(); // Logs WHY and HOW it was disposed/returned

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('confiscated_items');
    }
};
