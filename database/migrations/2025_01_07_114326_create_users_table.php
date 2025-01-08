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
        Schema::create('users', function (Blueprint $table) {
            $table->id('UserID'); // UNSIGNED BIGINT
            $table->string('Username', 50)->unique();
            $table->string('Email', 100)->unique();
            $table->string('PasswordHash');
            $table->enum('Role', ['Developer', 'Client', 'Admin'])->default('Client');
            $table->string('ProfilePicture', 500)->nullable();
            $table->text('Bio')->nullable();
            $table->enum('Language', ['English', 'Spanish', 'French', 'German'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};