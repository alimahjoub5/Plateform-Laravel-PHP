<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestimonialsTable extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
        {
        if (!Schema::hasTable('testimonials')) {
            Schema::create('testimonials', function (Blueprint $table) {
                $table->id('TestimonialID');
                $table->unsignedBigInteger('ClientID');
                $table->unsignedBigInteger('ProjectID');
                $table->text('Content');
                $table->integer('Rating');
                $table->enum('Status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
                $table->text('AdminComment')->nullable();
                $table->timestamps();

                // Foreign key constraints
                $table->foreign('ClientID')->references('UserID')->on('users')->onDelete('cascade');
                $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
}
