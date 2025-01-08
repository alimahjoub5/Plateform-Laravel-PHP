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
        Schema::create('analytics', function (Blueprint $table) {
            $table->id('AnalyticsID'); // Primary key
            $table->string('PageVisited', 255);
            $table->unsignedBigInteger('UserID')->nullable(); // Foreign key to users table
            $table->enum('Action', ['View', 'Click', 'Submit'])->default('View');
            $table->enum('DeviceType', ['Desktop', 'Mobile', 'Tablet'])->default('Desktop');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};