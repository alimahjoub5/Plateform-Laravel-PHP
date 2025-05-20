<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Project;
use App\Models\payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ContactInfo;

class InvoiceController extends Controller
{
    /**
     * Afficher la liste des factures.
     */
    
    public function download($id)
    {
        // Récupérer la facture avec les relations nécessaires
        $invoice = Invoice::with(['client', 'project', 'payments'])->findOrFail($id);
    
        // Générer le PDF
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
    
        // Télécharger le PDF
        return $pdf->download('facture-' . $invoice->InvoiceID . '.pdf');
    }

    public function pdf($id)
    {
        $invoice = Invoice::with(['client', 'project', 'payments'])->findOrFail($id);
        $contactInfo = ContactInfo::first();

        $pdf = PDF::loadView('invoices.pdf', compact('invoice', 'contactInfo'));
        
        return $pdf->download('facture-' . $invoice->InvoiceID . '.pdf');
    }

    public function index()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();
    
        // Si l'utilisateur est un admin, afficher toutes les factures
        if ($user->Role === 'Admin') {
            $invoices = Invoice::with(['client', 'project'])->get();
        }
        // Sinon, afficher uniquement les factures du client connecté
        else {
            $invoices = Invoice::with(['client', 'project'])
                ->where('ClientID', $user->UserID)
                ->get();
        }
    
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Afficher le formulaire de création d'une facture.
     */
    public function create($projectID)
    {
        // Récupérer le projet associé
        $project = Project::findOrFail($projectID);

        // Récupérer le client associé au projet
        $client = $project->client;

        return view('invoices.create', compact('project', 'client'));
    }

    /**
     * Enregistrer une nouvelle facture.
     */
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'ProjectID' => 'required|exists:projects,ProjectID',
            'ClientID' => 'required|exists:users,UserID',
            'Amount' => 'required|numeric|min:0',
            'DueDate' => 'required|date',
            'Status' => 'required|in:Pending,Paid,Overdue',
            'Description' => 'nullable|string', // Ajoutez cette ligne
        ]);
    
        // Création de la facture
        $invoice = Invoice::create([
            'ProjectID' => $request->ProjectID,
            'ClientID' => $request->ClientID,
            'Amount' => $request->Amount,
            'DueDate' => $request->DueDate,
            'Status' => $request->Status,
            'Description' => $request->Description, // Ajoutez cette ligne
        ]);
    
        // Redirection avec un message de succès
        return redirect()->route('invoices.show', $invoice->InvoiceID)
                         ->with('success', 'Facture créée avec succès.');
    }

    /**
     * Afficher les détails d'une facture.
     */
    public function show(Invoice $invoice)
    {
        // Charger les relations client et projet
        $invoice->load(['client', 'project']);
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Afficher le formulaire de modification d'une facture.
     */
    public function edit(Invoice $invoice)
    {
        // Vérifier si l'utilisateur est un admin
        if (Auth::user()->Role !== 'Admin') {
            return redirect()->route('invoices.show', ['invoice' => $invoice->InvoiceID])
                ->with('error', 'Vous n\'avez pas les droits pour modifier cette facture.');
        }

        // Récupérer le projet et le client associés
        $project = $invoice->project;
        $client = $invoice->client;

        return view('invoices.edit', compact('invoice', 'project', 'client'));
    }

    /**
     * Mettre à jour une facture.
     */
    public function update(Request $request, Invoice $invoice)
    {
        // Vérifier si l'utilisateur est un admin
        if (Auth::user()->Role !== 'Admin') {
            return redirect()->route('invoices.show', ['invoice' => $invoice->InvoiceID])
                ->with('error', 'Vous n\'avez pas les droits pour modifier cette facture.');
        }

        // Validation des données
        $request->validate([
            'Amount' => 'required|numeric|min:0',
            'DueDate' => 'required|date',
            'Status' => 'required|in:Pending,Paid,Overdue',
            'Description' => 'nullable|string',
        ]);

        // Mettre à jour la facture
        $invoice->update([
            'Amount' => $request->Amount,
            'DueDate' => $request->DueDate,
            'Status' => $request->Status,
            'Description' => $request->Description,
        ]);

        // Redirection avec un message de succès
        return redirect()->route('invoices.show', ['invoice' => $invoice->InvoiceID])
            ->with('success', 'La facture a été mise à jour avec succès.');
    }

    /**
     * Supprimer une facture.
     */
    public function destroy(Invoice $invoice)
    {
        // Supprimer la facture
        $invoice->delete();

        // Redirection avec un message de succès
        return redirect()->route('projects.show', $invoice->ProjectID)
                         ->with('success', 'La facture a été supprimée avec succès.');
    }
}