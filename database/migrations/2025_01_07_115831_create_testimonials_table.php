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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id('TestimonialID'); // Primary key
            $table->unsignedBigInteger('ClientID'); // Foreign key to users table
            $table->unsignedBigInteger('ProjectID'); // Foreign key to projects table
            $table->text('Feedback');
            $table->integer('Rating')->checkBetween(1, 5); // Ensure rating is between 1 and 5
            $table->boolean('IsApproved')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('ClientID')->references('UserID')->on('users')->onDelete('cascade');
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};