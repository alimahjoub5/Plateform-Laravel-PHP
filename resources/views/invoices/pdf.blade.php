<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $invoice->InvoiceID }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 9.5px;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .invoice-container {
            width: 100%;
            padding: 0;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 15px;
        }
        .invoice-header h1 {
            font-size: 16px;
            margin: 0;
        }
        .invoice-header p {
            font-size: 9px;
            margin: 3px 0;
        }
        .company-info, .rib-section {
            font-size: 9px;
            margin-bottom: 8px;
        }
        .section {
            margin-bottom: 12px;
        }
        .section h2 {
            font-size: 11px;
            margin-bottom: 6px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            font-size: 9px;
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .invoice-footer {
            text-align: center;
            font-size: 8.5px;
            color: #666;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">

        <!-- Infos entreprise -->
        <div class="company-info">
            <strong>Nom de l'entreprise</strong><br>
            Rue de l'Entreprise, 1000 Tunis<br>
            Email : contact@entreprise.tn — Tel : +216 20 000 000<br>
            Matricule Fiscal : 1234567/A/M/000
        </div>

        <!-- En-tête -->
        <div class="invoice-header">
            <h1>Facture #{{ $invoice->InvoiceID }}</h1>
            <p>Émise le : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>

        <!-- Infos facture -->
        <div class="section">
            <h2>Informations de la facture</h2>
            <table>
                <tr><th>Montant TTC</th><td>{{ number_format($invoice->Amount, 2, ',', ' ') }} €</td></tr>
                <tr><th>Date d'échéance</th><td>{{ \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') }}</td></tr>
                <tr><th>Statut</th><td>{{ $invoice->Status }}</td></tr>
            </table>
        </div>

        <!-- Description -->
        <div class="section">
            <h2>Description</h2>
            <p>{{ $invoice->Description ?? 'Aucune description fournie.' }}</p>
        </div>

        <!-- Client -->
        <div class="section">
            <h2>Client</h2>
            <table>
                <tr><th>Nom d'utilisateur</th><td>{{ $invoice->client->Username }}</td></tr>
                <tr><th>Prénom</th><td>{{ $invoice->client->FirstName }}</td></tr>
                <tr><th>Nom</th><td>{{ $invoice->client->LastName }}</td></tr>
                <tr><th>Email</th><td>{{ $invoice->client->Email }}</td></tr>
                <tr><th>Téléphone</th><td>{{ $invoice->client->PhoneNumber }}</td></tr>
                <tr><th>Adresse</th><td>{{ $invoice->client->Address }}</td></tr>
            </table>
        </div>

        <!-- Projet -->
        <div class="section">
            <h2>Projet</h2>
            <table>
                <tr><th>Titre</th><td>{{ $invoice->project->Title }}</td></tr>
                <tr><th>Description</th><td>{{ $invoice->project->Description }}</td></tr>
                <tr><th>Budget</th><td>{{ number_format($invoice->project->Budget, 2, ',', ' ') }} €</td></tr>
            </table>
        </div>

        <!-- Paiements -->
        <div class="section">
            <h2>Historique des paiements</h2>
            <table>
                <thead>
                    <tr>
                        <th>Méthode</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_method }}</td>
                            <td>{{ number_format($payment->amount, 2, ',', ' ') }} €</td>
                            <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $payment->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Message -->
        <div class="section">
            <h2>Message</h2>
            <p>Merci pour votre confiance. Pour toute question, contactez-nous.</p>
        </div>

        <!-- RIB -->
<!-- Coordonnées bancaires et PayPal -->
<div class="rib-section">
    <h2>Coordonnées de paiement</h2>
    <table>
        <tr>
            <th style="width: 30%;">Par virement bancaire</th>
            <td>
                Banque : Banque de Développement<br>
                IBAN : TN59 1000 6035 0000 1234 5678<br>
                BIC / SWIFT : BDTTNTTT
            </td>
        </tr>
        <tr>
            <th>Par PayPal</th>
            <td>
                Adresse PayPal : paiement@entreprise.tn<br>
                (Merci d'indiquer le numéro de la facture dans la note du paiement.)
            </td>
        </tr>
    </table>
</div>


        <!-- Footer -->
        <div class="invoice-footer">
            &copy; {{ date('Y') }} Nom de l'entreprise — www.entreprise.tn
        </div>
    </div>
</body>
</html>
