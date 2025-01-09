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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id('PortfolioID'); // Primary key
            $table->unsignedBigInteger('ProjectID'); // Foreign key to projects table
            $table->string('Title', 255);
            $table->text('Description');
            $table->string('ImageURL', 500)->nullable();
            $table->string('LiveLink', 500)->nullable();
            $table->enum('Category', ['Web Development', 'Mobile App', 'Design', 'Other'])->default('Other');
            $table->json('Tags')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};