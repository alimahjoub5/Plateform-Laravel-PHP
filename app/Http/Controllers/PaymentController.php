<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    // Afficher le formulaire de paiement
    public function showPaymentForm($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        $initialAmount = $invoice->amount * 0.3; // 30% du total
        return view('payment.form', compact('invoice', 'initialAmount'));
    }

    // Traiter le paiement via Stripe
    public function processPayment(Request $request, $invoiceId)
{
    $invoice = Invoice::findOrFail($invoiceId);

    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        // Convertir le montant en centimes
        $amountInCents = intval($invoice->Amount * 100);

        // Créer un PaymentIntent avec Stripe
        $paymentIntent = PaymentIntent::create([
            'amount' => $amountInCents, // Montant en centimes
            'currency' => 'eur', // Devise
            'payment_method' => $request->payment_method, // ID de la méthode de paiement
            'confirmation_method' => 'manual',
            'confirm' => true, // Confirmer immédiatement
            'return_url' => route('payment.success'), // URL de retour pour les redirections
        ]);

        // Enregistrer le paiement dans la base de données
        Payment::create([
            'invoice_id' => $invoiceId,
            'amount' => $invoice->Amount,
            'payment_method' => 'stripe',
            'transaction_id' => $paymentIntent->id,
            'status' => 'completed',
        ]);

        return redirect()->route('payment.success')->with('success', 'Paiement réussi !');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erreur lors du paiement : ' . $e->getMessage());
    }
}

    // Afficher la page de succès
    public function paymentSuccess()
    {
        return view('payment.success');
    }
}