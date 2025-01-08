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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id('BlogID'); // Primary key
            $table->string('Title', 255);
            $table->text('Content');
            $table->unsignedBigInteger('AuthorID'); // Foreign key to users table
            $table->enum('Category', ['Tutorial', 'Case Study', 'News', 'Other'])->default('Other');
            $table->string('FeaturedImage', 500)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('AuthorID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};