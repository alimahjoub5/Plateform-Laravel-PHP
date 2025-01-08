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
        Schema::create('projects', function (Blueprint $table) {
            $table->id('ProjectID'); // UNSIGNED BIGINT
            $table->string('Title', 255);
            $table->text('Description');
            $table->unsignedBigInteger('ClientID'); // Match the type with users.id
            $table->decimal('Budget', 15, 2)->nullable();
            $table->date('Deadline')->nullable();
            $table->enum('Status', ['Pending', 'In Progress', 'Completed', 'Cancelled'])->default('Pending');
            
            // Nouvelle colonne pour l'approbation
            $table->enum('ApprovalStatus', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('ClientID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};