<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Afficher la liste des factures.
     */
    public function index()
    {
        $invoices = Invoice::with('client')->get(); // Charger les clients associés
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Afficher le formulaire de création d'une facture.
     */
    public function create()
    {
        $clients = Client::all(); // Récupérer tous les clients pour le formulaire
        return view('invoices.create', compact('clients'));
    }

    /**
     * Enregistrer une nouvelle facture.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
        ]);

        Invoice::create($request->all());

        return redirect()->route('invoices.index')->with('success', 'Facture créée avec succès.');
    }

    /**
     * Afficher les détails d'une facture.
     */
    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Afficher le formulaire de modification d'une facture.
     */
    public function edit(Invoice $invoice)
    {
        $clients = Client::all(); // Récupérer tous les clients pour le formulaire
        return view('invoices.edit', compact('invoice', 'clients'));
    }

    /**
     * Mettre à jour une facture.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|in:paid,unpaid',
        ]);

        $invoice->update($request->all());

        return redirect()->route('invoices.index')->with('success', 'Facture mise à jour avec succès.');
    }

    /**
     * Supprimer une facture.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Facture supprimée avec succès.');
    }
}