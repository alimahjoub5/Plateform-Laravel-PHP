<?php

namespace App\Observers;

use App\Models\Invoice;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        //
    }


        /**
         * Écoute l'événement "updated" du modèle Invoice.
         */
        public function updated(Invoice $invoice)
        {
            if ($invoice->isDirty('Status') && $invoice->Status === 'Paid') {
                // Enregistrer un paiement associé
                Payment::create([
                    'invoice_id' => $invoice->InvoiceID,
                    'amount' => $invoice->Amount,
                    'payment_method' => 'PayPal', // ou une autre méthode
                    'status' => 'completed',
                ]);
            }
        }
    

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        //
    }
}
