<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('founder_id')->nullable();

            // NEW: Differentiates the workflow context
            $table->enum('report_type', ['Lost', 'Found'])->default('Lost');

            $table->string('item_category');
            $table->text('description')->nullable();
            $table->string('location_found')->nullable();
            $table->date('date_lost')->nullable();
            $table->string('image_path')->nullable();
            $table->string('status')->default('Active'); // Active, Pending Review, Matched, Claimed
            $table->boolean('is_claimed')->default(false);
            $table->boolean('is_stock_image')->default(false);

            // NEW: The "Black Hole" Fix for admins
            $table->boolean('flagged_for_review')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};
