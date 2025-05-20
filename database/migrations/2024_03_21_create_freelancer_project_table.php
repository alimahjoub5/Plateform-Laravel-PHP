<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('freelancer_project', function (Blueprint $table) {
            $table->unsignedBigInteger('FreelancerID');
            $table->unsignedBigInteger('ProjectID');
            $table->timestamps();

            $table->foreign('FreelancerID')
                  ->references('UserID')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('ProjectID')
                  ->references('ProjectID')
                  ->on('projects')
                  ->onDelete('cascade');

            $table->unique(['FreelancerID', 'ProjectID']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('freelancer_project');
    }
}; 