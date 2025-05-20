<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devis_id')->constrained('devis', 'DevisID')->onDelete('cascade');
            $table->text('message');
            $table->enum('sender_type', ['client', 'admin']);
            $table->foreignId('sender_id')->constrained('users', 'UserID');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('negotiations');
    }
}; 