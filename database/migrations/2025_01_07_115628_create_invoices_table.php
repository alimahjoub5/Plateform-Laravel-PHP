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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('InvoiceID'); // Primary key
            $table->unsignedBigInteger('ProjectID'); // Foreign key to projects table
            $table->unsignedBigInteger('ClientID'); // Foreign key to users table
            $table->decimal('Amount', 15, 2);
            $table->enum('Status', ['Pending', 'Paid', 'Overdue'])->default('Pending');
            $table->date('DueDate');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onDelete('cascade');
            $table->foreign('ClientID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};