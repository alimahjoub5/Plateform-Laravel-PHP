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
        //
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id'); // Project associated with the chat
            $table->unsignedBigInteger('sender_id');  // User who sent the message
            $table->unsignedBigInteger('receiver_id'); // User who receives the message
            $table->text('message');                  // The message content
            $table->boolean('is_read')->default(false); // Whether the message has been read
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
