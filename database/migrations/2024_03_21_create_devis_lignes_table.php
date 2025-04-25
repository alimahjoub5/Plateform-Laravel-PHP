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
        Schema::create('devis_lignes', function (Blueprint $table) {
            $table->id('LigneID');
            $table->unsignedBigInteger('DevisID');
            $table->string('Description');
            $table->decimal('Quantite', 10, 2);
            $table->decimal('PrixUnitaire', 10, 2);
            $table->decimal('TotalHT', 10, 2);
            $table->timestamps();

            // Clé étrangère vers la table devis
            $table->foreign('DevisID')
                  ->references('DevisID')
                  ->on('devis')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis_lignes');
    }
}; 