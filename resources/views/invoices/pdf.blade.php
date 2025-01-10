<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $invoice->InvoiceID }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Texte plus petit */
            color: #333; /* Couleur de texte plus douce */
            background-color: #fff;
            line-height: 1.4;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd; /* Bordure légère */
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            font-size: 18px;
            margin: 0;
            color: #000;
        }
        .invoice-header p {
            font-size: 12px;
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin-bottom: 15px;
        }
        .section h2 {
            font-size: 14px;
            margin: 0 0 10px 0;
            color: #000;
            border-bottom: 1px solid #ddd; /* Ligne de séparation */
            padding-bottom: 5px;
        }
        .section table {
            width: 100%;
            border-collapse: collapse;
        }
        .section th, .section td {
            border: 1px solid #ddd; /* Bordures plus légères */
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        .section th {
            background-color: #f9f9f9; /* Fond légèrement gris pour les en-têtes */
            font-weight: bold;
        }
        .invoice-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- En-tête de la facture -->
        <div class="invoice-header">
            <h1>Facture #{{ $invoice->InvoiceID }}</h1>
            <p>Date d'émission : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>

        <!-- Informations de la facture -->
        <div class="section">
            <h2>Informations de la facture</h2>
            <table>
                <tr>
                    <th>Montant</th>
                    <td>{{ number_format($invoice->Amount, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <th>Date d'échéance</th>
                    <td>{{ \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td>{{ $invoice->Status }}</td>
                </tr>
            </table>
        </div>

        <!-- Informations du client -->
        <div class="section">
            <h2>Informations du client</h2>
            <table>
                <tr>
                    <th>Nom</th>
                    <td>{{ $invoice->client->Username }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $invoice->client->email }}</td>
                </tr>
                <tr>
                    <th>Téléphone</th>
                    <td>{{ $invoice->client->phone }}</td>
                </tr>
                <tr>
                    <th>Adresse</th>
                    <td>{{ $invoice->client->address }}</td>
                </tr>
            </table>
        </div>

        <!-- Informations du projet -->
        <div class="section">
            <h2>Informations du projet</h2>
            <table>
                <tr>
                    <th>Titre du projet</th>
                    <td>{{ $invoice->project->Title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $invoice->project->Description }}</td>
                </tr>
                <tr>
                    <th>Budget</th>
                    <td>{{ number_format($invoice->project->Budget, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <th>Date limite</th>
                    <td>{{ \Carbon\Carbon::parse($invoice->project->Deadline)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td>{{ $invoice->project->Status }}</td>
                </tr>
            </table>
        </div>

        <!-- Historique des paiements -->
        <div class="section">
            <h2>Historique des paiements</h2>
            <table>
                <thead>
                    <tr>
                        <th>Méthode de paiement</th>
                        <th>Montant payé</th>
                        <th>Date du paiement</th>
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

        <!-- Pied de page -->
        <div class="invoice-footer">
            <p>Merci pour votre confiance. Pour toute question, contactez-nous à l'adresse email@example.com.</p>
        </div>
    </div>
</body>
</html>