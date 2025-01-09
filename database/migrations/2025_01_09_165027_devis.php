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
        Schema::create('devis', function (Blueprint $table) {
            $table->id('DevisID'); // Clé primaire
            $table->unsignedBigInteger('ProjectID'); // Clé étrangère vers la table projects
            $table->unsignedBigInteger('ClientID'); // Clé étrangère vers la table users (client)
            $table->string('Reference', 50)->unique(); // Référence unique du devis
            $table->date('DateEmission'); // Date d'émission du devis
            $table->date('DateValidite'); // Date de validité du devis
            $table->decimal('TotalHT', 15, 2); // Total HT
            $table->decimal('TVA', 5, 2); // Taux de TVA
            $table->decimal('TotalTTC', 15, 2); // Total TTC
            $table->enum('Statut', ['En attente', 'Accepté', 'Refusé', 'Modifié'])->default('En attente'); // Statut du devis
            $table->text('ConditionsGenerales')->nullable(); // Conditions générales
            $table->timestamps();

            // Clés étrangères
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onDelete('cascade');
            $table->foreign('ClientID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};