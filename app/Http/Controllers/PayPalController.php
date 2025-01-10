<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Pour les transactions
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Invoice;
use App\Models\Payment;

class PayPalController extends Controller
{
    // Afficher le formulaire de paiement
    public function showPaymentForm($invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
        return view('payment.paypal', compact('invoice'));
    }

    // Créer un paiement PayPal
    public function createPayment(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        // Créer la commande PayPal
        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "EUR", // Devise en euros
                        "value" => $invoice->Amount
                    ],
                    "description" => "Payment for Invoice #" . $invoice->InvoiceID
                ]
            ]
        ]);

        // Rediriger vers l'URL d'approbation PayPal
        if (isset($order['id']) && $order['status'] === 'CREATED') {
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        // En cas d'erreur, rediriger avec un message d'erreur
        return redirect()->back()->with('error', 'Échec de la création du paiement PayPal.');
    }

    public function processPayment(Request $request, $invoiceId)
{
    // Récupérer la facture
    $invoice = Invoice::findOrFail($invoiceId);

    \Log::info('PayPal Payment Request:', $request->all());

    try {
        // Vérifier si un paiement a déjà été enregistré pour cette facture
        $existingPayment = Payment::where('invoice_id', $invoiceId)->first();
        if ($existingPayment) {
            return redirect()->back()->with('error', 'Un paiement a déjà été effectué pour cette facture.');
        }

        // Initialiser le client PayPal
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);

        // Récupérer les détails de la commande PayPal
        $orderDetails = $provider->showOrderDetails($request->orderID);
        \Log::info('PayPal Order Details:', $orderDetails);

        // Vérifier si la commande a déjà été capturée
        $isAlreadyCaptured = isset($orderDetails['status']) && $orderDetails['status'] === 'COMPLETED';

        // Capturer le paiement si ce n'est pas déjà fait
        if (!$isAlreadyCaptured) {
            $response = $provider->capturePaymentOrder($request->orderID);
            \Log::info('PayPal Payment Response:', $response);

            // Vérifier si la capture est réussie
            if (!isset($response['status']) || $response['status'] !== 'COMPLETED') {
                throw new \Exception('La capture du paiement a échoué.');
            }
        } else {
            // Utiliser les détails de la commande existante si déjà capturée
            $response = $orderDetails;
        }

        // Mettre à jour le statut de la facture
        $invoice->update([
            'Status' => 'Paid', // Mettre à jour le statut de la facture
        ]);

        // Enregistrer les détails du paiement
        Payment::create([
            'invoice_id' => $invoiceId,
            'amount' => $response['purchase_units'][0]['amount']['value'],
            'payment_method' => 'PayPal',
            'transaction_id' => $response['id'],
            'status' => 'completed',
        ]);

        // Rediriger vers la page de succès avec un message de succès
        return redirect()->route('payment.success')->with('success', 'Paiement réussi !');
    } catch (\Exception $e) {
        // En cas d'erreur, logger l'erreur et rediriger avec un message d'erreur
        \Log::error('Erreur lors du traitement du paiement : ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors du traitement du paiement.');
    }
}

    // Afficher la page de succès
    public function paymentSuccess()
    {
        return view('payment.success');
    }
}