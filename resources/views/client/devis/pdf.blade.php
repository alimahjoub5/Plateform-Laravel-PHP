<!DOCTYPE html>
<html>
<head>
    <title>Devis #{{ $devis->Reference }}</title>
    <style>
        /* Réglages généraux pour le format A4 */
        @page {
            size: A4;
            margin: 15mm; /* Marges optimisées pour l'impression */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            width: 100%;
            max-width: 800px;
            color: #333;
            line-height: 1.5;
            font-size: 12px;
            padding: 0 10mm;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-logo {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .company-info {
            font-size: 12px;
            margin-bottom: 20px;
        }
        .company-info p {
            margin: 4px 0;
        }
        h1 {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            color: #000;
        }
        h2 {
            font-size: 14px;
            color: #000;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
            margin-bottom: 15px;
        }
        .section {
            margin-bottom: 15px;
        }
        .section p {
            margin: 8px 0;
        }
        .section strong {
            font-weight: bold;
            color: #333;
        }
        .totals {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 25px;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .totals table td {
            padding: 8px;
            border-top: 1px solid #ddd;
            text-align: right;
        }
        .totals table td:first-child {
            font-weight: bold;
        }
        .conditions {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 25px;
        }
        .signature {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 30px;
        }
        .signature p {
            margin: 0;
        }
        .signature div {
            margin-top: 15px;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
            color: #000;
        }
        @media print {
            body {
                margin: 0;
            }
            header, footer {
                display: none;
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('images/logo.png') }}" alt="Logo de l'entreprise" class="company-logo">
        <div class="company-info">
            <p>{{ $contactInfo->address ?? 'Adresse non spécifiée' }}</p>
            <p>Téléphone: {{ $contactInfo->phone ?? 'Non spécifié' }}</p>
            <p>Email: {{ $contactInfo->email ?? 'Non spécifié' }}</p>
            <p>SIRET: {{ $contactInfo->siret ?? 'Non spécifié' }}</p>
        </div>
    </header>

    <main>
        <h1>Devis #{{ $devis->Reference }}</h1>

        <!-- Informations du Client -->
        <div class="section">
            <h2>Informations du Client</h2>
            <p><strong>Nom :</strong> {{ $devis->client->Username ?? 'Non spécifié' }}</p>
            <p><strong>Email :</strong> {{ $devis->client->Email ?? 'Non spécifié' }}</p>
            <p><strong>Téléphone :</strong> {{ $devis->client->Phone ?? 'Non spécifié' }}</p>
            <p><strong>Adresse :</strong> {{ $devis->client->Address ?? 'Non spécifié' }}</p>
        </div>

        <!-- Informations du Projet -->
        <div class="section">
            <h2>Informations du Projet</h2>
            <p><strong>Titre :</strong> {{ $devis->project->Title ?? 'Non spécifié' }}</p>
            <p><strong>Description :</strong> {{ $devis->project->Description ?? 'Non spécifié' }}</p>
            <p><strong>Propriétaire du projet :</strong> {{ $devis->project->OwnerName ?? 'Non spécifié' }}</p>
        </div>

        <!-- Informations du Créateur du Devis -->
        <div class="section">
            <h2>Créé par</h2>
            <p><strong>Nom :</strong> {{ $devis->createdBy->Username ?? 'Non spécifié' }}</p>
            <p><strong>Email :</strong> {{ $devis->createdBy->Email ?? 'Non spécifié' }}</p>
            <p><strong>Rôle :</strong> {{ $devis->createdBy->Role ?? 'Non spécifié' }}</p>
        </div>

        <!-- Détails du Devis -->
        <div class="section">
            <h2>Détails du Devis</h2>
            <p><strong>Date d'émission :</strong> {{ $devis->DateEmission ?? 'Non spécifié' }}</p>
            <p><strong>Date de validité :</strong> {{ $devis->DateValidite ?? 'Non spécifié' }}</p>
        </div>

        <!-- Totaux -->
        <div class="totals">
            <h2>Totaux</h2>
            <table>
                <tr>
                    <td>Total HT :</td>
                    <td>{{ number_format($devis->TotalHT, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td>TVA ({{ $devis->TVA }}%) :</td>
                    <td>{{ number_format($devis->TotalHT * ($devis->TVA / 100), 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                    <td>Total TTC :</td>
                    <td>{{ number_format($devis->TotalTTC, 2, ',', ' ') }} €</td>
                </tr>
            </table>
        </div>

        <!-- Conditions Générales -->
        <div class="conditions">
            <h2>Conditions Générales</h2>
            <div class="conditions-content">
                {!! $devis->ConditionsGenerales !!}
            </div>
        </div>

        <!-- Signature -->
        <div class="signature">
            <h2>Signature</h2>
            <p>Le client reconnaît avoir pris connaissance de ce devis et accepte les conditions générales.</p>
            <div>
                @if ($devis->signature)
                    <p>Signature du client :</p>
                    <img src="data:image/png;base64,{{ $devis->signature }}" alt="Signature du client" style="max-width: 20%; height: auto; border: 0;">
                @endif
                <p>Date : {{ $devis->updated_at }}</p>
            </div>
        </div>
    </main>

    <footer>
        <p>Contact : {{ $contactInfo->email }} | Téléphone : {{ $contactInfo->Phone }}</p>
    </footer>
</body>
</html>
