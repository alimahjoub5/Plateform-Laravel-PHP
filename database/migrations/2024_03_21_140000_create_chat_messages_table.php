<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id('MessageID');
            $table->foreignId('ProjectID')->constrained('projects', 'ProjectID')->onDelete('cascade');
            $table->foreignId('SenderID')->constrained('users', 'UserID')->onDelete('cascade');
            $table->text('Message');
            $table->boolean('IsRead')->default(false);
            $table->string('AttachmentURL')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
}; 