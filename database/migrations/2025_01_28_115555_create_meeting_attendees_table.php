<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('meeting_attendees', function (Blueprint $table) {
            $table->unsignedBigInteger('MeetingID');
            $table->unsignedBigInteger('UserID');
            $table->timestamps();
    
            // Clés étrangères
            $table->foreign('MeetingID')->references('MeetingID')->on('meetings')->onDelete('cascade');
            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
    
            // Clé primaire composite
            $table->primary(['MeetingID', 'UserID']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_attendees');
    }
};
