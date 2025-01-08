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
// database/migrations/xxxx_xx_xx_create_services_table.php
Schema::create('services', function (Blueprint $table) {
    $table->id('ServiceID');
    $table->string('ServiceName', 255);
    $table->text('Description');
    $table->decimal('Price', 10, 2);
    $table->enum('Category', ['Development', 'Design', 'Consulting', 'Other'])->default('Other');
    $table->boolean('IsAvailable')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
