<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('reporter_name');
            $table->string('reporter_email')->nullable();
            $table->string('reporter_affiliation')->nullable(); // e.g., Student, Faculty, Guard
            $table->date('incident_date');
            $table->string('incident_location');
            $table->string('incident_category');
            $table->string('severity')->default('Routine');
            $table->text('description');
            $table->string('status')->default('Pending Review');
            $table->text('action_taken')->nullable();
            $table->string('evidence_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
