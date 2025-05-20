<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $invoice->InvoiceID }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 15mm;
        }
        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
            color: #000;
            line-height: 1.3;
        }

        .invoice-container {
            width: 100%;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #2f5496;
            padding-bottom: 15px;
        }

        .company-info {
            text-align: left;
            flex: 1;
        }

        .company-logo {
            max-width: 120px;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 14pt;
            font-weight: bold;
            color: #2f5496;
            margin-bottom: 5px;
        }

        .company-details {
            font-size: 9pt;
            line-height: 1.4;
        }

        .invoice-info {
            text-align: right;
            flex: 1;
        }

        .invoice-title {
            font-size: 16pt;
            font-weight: bold;
            color: #2f5496;
            margin-bottom: 10px;
        }

        .invoice-details {
            font-size: 9pt;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 11pt;
            font-weight: bold;
            color: #2f5496;
            margin-bottom: 10px;
            border-bottom: 1px solid #2f5496;
            padding-bottom: 3px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 15px 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .info-table th, .info-table td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 9pt;
        }

        .info-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
        }

        .amount-table {
            width: 50%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .amount-table th, .amount-table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 10pt;
        }

        .amount-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
        }

        .amount-table td:last-child {
            text-align: right;
        }

        .amount-table tr:last-child td {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        .payment-info {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }

        .payment-info h3 {
            font-size: 11pt;
            color: #2f5496;
            margin-bottom: 10px;
        }

        .payment-info p {
            margin: 5px 0;
            font-size: 9pt;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 8pt;
            color: #666;
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
            margin: 5px 0;
        }

        .status.paid {
            background-color: #d4edda;
            color: #155724;
        }

        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status.overdue {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media print {
            body {
                width: 210mm;
                height: 297mm;
            }
            .section {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="company-info">
                <img src="{{ public_path('images/logo.png') }}" alt="Logo" class="company-logo">
                <div class="company-name">{{ config('app.name') }}</div>
                <div class="company-details">
                    {{ $contactInfo->address ?? 'Adresse non spécifiée' }}<br>
                    Téléphone: {{ $contactInfo->phone ?? 'Non spécifié' }}<br>
                    Email: {{ $contactInfo->email ?? 'Non spécifié' }}<br>
                    SIRET: {{ $contactInfo->siret ?? 'Non spécifié' }}
                </div>
            </div>
            <div class="invoice-info">
                <div class="invoice-title">FACTURE</div>
                <div class="invoice-details">
                    N° {{ $invoice->InvoiceID }}<br>
                    Date: {{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}<br>
                    Échéance: {{ \Carbon\Carbon::parse($invoice->DueDate)->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <div class="info-grid">
            <div class="section">
                <div class="section-title">Client</div>
                <table class="info-table">
                    <tr><th>Nom d'utilisateur</th><td>{{ $invoice->client->Username }}</td></tr>
                    <tr><th>Prénom</th><td>{{ $invoice->client->FirstName }}</td></tr>
                    <tr><th>Nom</th><td>{{ $invoice->client->LastName }}</td></tr>
                    <tr><th>Email</th><td>{{ $invoice->client->Email }}</td></tr>
                    <tr><th>Téléphone</th><td>{{ $invoice->client->PhoneNumber }}</td></tr>
                    <tr><th>Adresse</th><td>{{ $invoice->client->Address }}</td></tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">Projet</div>
                <table class="info-table">
                    <tr><th>Titre</th><td>{{ $invoice->project->Title }}</td></tr>
                    <tr><th>Description</th><td>{{ $invoice->project->Description }}</td></tr>
                    <tr><th>Budget</th><td>{{ number_format($invoice->project->Budget, 2, ',', ' ') }} €</td></tr>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Détails de la facture</div>
            <table class="amount-table">
                <tr>
                    <th>Montant HT</th>
                    <td>{{ number_format($invoice->Amount / 1.2, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <th>TVA (20%)</th>
                    <td>{{ number_format($invoice->Amount - ($invoice->Amount / 1.2), 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <th>Total TTC</th>
                    <td>{{ number_format($invoice->Amount, 2, ',', ' ') }} €</td>
                </tr>
            </table>
        </div>

        @if($invoice->Description)
        <div class="section">
            <div class="section-title">Description</div>
            <p>{{ $invoice->Description }}</p>
        </div>
        @endif

        @if($invoice->payments->count() > 0)
        <div class="section">
            <div class="section-title">Historique des paiements</div>
            <table class="info-table">
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
                            <td>
                                <span class="status {{ strtolower($payment->status) }}">
                                    {{ $payment->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="payment-info">
            <h3>Coordonnées de paiement</h3>
            <p><strong>Virement bancaire :</strong><br>
            Banque : Banque de Développement<br>
            IBAN : TN59 1000 6035 0000 1234 5678<br>
            BIC / SWIFT : BDTTNTTT</p>
            <p><strong>PayPal :</strong><br>
            paiement@entreprise.tn<br>
            <em>(Merci d'indiquer le numéro de la facture dans la note du paiement)</em></p>
        </div>

        <div class="footer">
            <p>{{ config('app.name') }} - {{ $contactInfo->address ?? 'Adresse non spécifiée' }}</p>
            <p>Téléphone : {{ $contactInfo->phone ?? 'Non spécifié' }} | Email : {{ $contactInfo->email ?? 'Non spécifié' }}</p>
            <p>SIRET : {{ $contactInfo->siret ?? 'Non spécifié' }}</p>
        </div>
    </div>
</body>
</html>
