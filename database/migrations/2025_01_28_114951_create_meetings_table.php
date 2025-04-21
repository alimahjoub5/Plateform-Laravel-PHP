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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id('MeetingID');
            $table->unsignedBigInteger('ProjectID'); // Réunion liée à un projet
            $table->unsignedBigInteger('OrganizerID'); // Utilisateur qui organise la réunion
            $table->string('Title');
            $table->text('Description')->nullable();
            $table->dateTime('StartTime');
            $table->dateTime('EndTime');
            $table->string('Location')->nullable(); // Lieu ou lien de la réunion
            $table->timestamps();
    
            // Clés étrangères
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onDelete('cascade');
            $table->foreign('OrganizerID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
