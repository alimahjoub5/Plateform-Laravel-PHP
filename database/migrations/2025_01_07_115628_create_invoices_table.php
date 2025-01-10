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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('InvoiceID'); // Clé primaire
            $table->unsignedBigInteger('ProjectID'); // Clé étrangère vers la table `projects`
            $table->unsignedBigInteger('ClientID'); // Clé étrangère vers la table `users`
            $table->decimal('Amount', 15, 2); // Montant de la facture
            $table->enum('Status', ['Pending', 'Paid', 'Overdue'])->default('Pending'); // Statut de la facture
            $table->date('DueDate'); // Date d'échéance
            $table->text('Description')->nullable(); // Nouvelle colonne pour la description
            $table->timestamps();
    
            // Contraintes de clé étrangère
            $table->foreign('ProjectID')->references('ProjectID')->on('projects')->onDelete('cascade');
            $table->foreign('ClientID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};