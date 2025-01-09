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
        Schema::table('devis', function (Blueprint $table) {
            $table->unsignedBigInteger('CreatedBy')->nullable()->after('Statut');
            $table->foreign('CreatedBy')->references('UserID')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropForeign(['CreatedBy']);
            $table->dropColumn('CreatedBy');
        });
    }
};
