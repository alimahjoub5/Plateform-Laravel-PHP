<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('time_tracking', function (Blueprint $table) {
            $table->id('TrackingID');
            $table->unsignedBigInteger('UserID');
            $table->unsignedBigInteger('TaskID');
            $table->text('Description');
            $table->dateTime('StartTime');
            $table->dateTime('EndTime')->nullable();
            $table->timestamps();

            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
            $table->foreign('TaskID')->references('TaskID')->on('tasks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('time_tracking');
    }
}; 