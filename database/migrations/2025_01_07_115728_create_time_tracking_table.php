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
        Schema::create('time_tracking', function (Blueprint $table) {
            $table->id('TimeTrackID'); // Primary key
            $table->unsignedBigInteger('TaskID'); // Foreign key to tasks table
            $table->unsignedBigInteger('DeveloperID'); // Foreign key to users table
            $table->dateTime('StartTime');
            $table->dateTime('EndTime')->nullable();
            $table->integer('Duration')->nullable(); // Duration in minutes
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('TaskID')->references('TaskID')->on('tasks')->onDelete('cascade');
            $table->foreign('DeveloperID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_tracking');
    }
};