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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('TaskID'); // UNSIGNED BIGINT
            $table->unsignedBigInteger('ProjectID'); // Match the type with projects.id
            $table->string('Title', 255);
            $table->text('Description')->nullable();
            $table->unsignedBigInteger('AssignedTo')->nullable(); // Match the type with users.id
            $table->enum('Status', ['To Do', 'In Progress', 'Completed'])->default('To Do');
            $table->date('DueDate')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('ProjectID')->references('ProjectID')->on('projects');
            $table->foreign('AssignedTo')->references('UserID')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};