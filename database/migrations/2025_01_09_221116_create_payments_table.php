<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id'); // Colonne pour la clé étrangère
            $table->foreign('invoice_id')->references('InvoiceID')->on('invoices')->onDelete('cascade'); // Référence `InvoiceID`
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // Stripe, PayPal, etc.
            $table->string('transaction_id')->nullable(); // ID de la transaction
            $table->string('status')->default('pending'); // pending, completed, failed
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};