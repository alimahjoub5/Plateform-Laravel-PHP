<!DOCTYPE html>
<html>
<head>
    <title>Devis #{{ $devis->Reference }}</title>
    <style>
        @page {
            size: A4;
            margin: 20mm 15mm;
        }
        body {
            font-family: 'Calibri', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            font-size: 10pt;
            line-height: 1.2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-logo {
            max-width: 80px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 8px;
        }
        .company-info {
            font-size: 9pt;
            line-height: 1.3;
        }
        .company-info p {
            margin: 2px 0;
        }

        .document-title {
            font-size: 14pt;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            text-transform: uppercase;
        }

        .section {
            margin-bottom: 12px;
        }
        .section-title {
            font-size: 11pt;
            font-weight: bold;
            margin: 12px 0 8px;
            color: #2f5496;
            border-bottom: 1px solid #2f5496;
            padding-bottom: 2px;
        }
        .section p {
            margin: 3px 0;
            font-size: 10pt;
        }
        .section strong {
            font-weight: bold;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 12px 0;
        }

        .totals {
            margin: 15px 0;
            width: 40%;
            margin-left: auto;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals table td {
            padding: 4px;
            border: 1px solid #000;
            font-size: 10pt;
        }
        .totals table td:first-child {
            font-weight: bold;
        }
        .totals table td:last-child {
            text-align: right;
        }
        .totals table tr:last-child td {
            font-weight: bold;
        }

        .conditions {
            margin: 15px 0;
        }
        .conditions-content {
            font-size: 10pt;
            line-height: 1.3;
        }

        .signature {
            margin: 20px 0;
        }
        .signature p {
            margin: 3px 0;
            font-size: 10pt;
        }
        .signature img {
            max-width: 120px;
            height: auto;
            margin: 8px 0;
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            font-size: 10pt;
            font-weight: bold;
            margin: 8px 0;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #000;
            font-size: 8pt;
            color: #666;
        }

        @media print {
            body {
                width: 210mm;
                height: 297mm;
            }
            .section, .totals, .conditions, .signature {
                break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo de l'entreprise" class="company-logo">
        <div class="company-name">{{ config('app.name') }}</div>
        <div class="company-info">
            <p>{{ $contactInfo->address ?? 'Adresse non spécifiée' }}</p>
            <p>Téléphone: {{ $contactInfo->phone ?? 'Non spécifié' }}</p>
            <p>Email: {{ $contactInfo->email ?? 'Non spécifié' }}</p>
            <p>SIRET: {{ $contactInfo->siret ?? 'Non spécifié' }}</p>
        </div>
    </div>

    <div class="document-title">Devis #{{ $devis->Reference }}</div>

    <div class="status">
        {{ $devis->Statut }}
    </div>

    <div class="info-grid">
        <div class="section">
            <div class="section-title">Informations du Client</div>
            <p><strong>Nom d'utilisateur :</strong> {{ $devis->client->Username ?? 'Non spécifié' }}</p>
            <p><strong>Prénom :</strong> {{ $devis->client->FirstName ?? 'Non spécifié' }}</p>
            <p><strong>Nom :</strong> {{ $devis->client->LastName ?? 'Non spécifié' }}</p>
            <p><strong>Email :</strong> {{ $devis->client->Email ?? 'Non spécifié' }}</p>
            <p><strong>Téléphone :</strong> {{ $devis->client->PhoneNumber ?? 'Non spécifié' }}</p>
            <p><strong>Adresse :</strong> {{ $devis->client->Address ?? 'Non spécifié' }}</p>
        </div>

        <div class="section">
            <div class="section-title">Informations du Projet</div>
            <p><strong>Titre :</strong> {{ $devis->project->Title ?? 'Non spécifié' }}</p>
            <p><strong>Description :</strong> {{ $devis->project->Description ?? 'Non spécifié' }}</p>
            <p><strong>Propriétaire du projet :</strong> {{ $devis->project->OwnerName ?? 'Non spécifié' }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Créé par</div>
        <div class="info-grid">
            <div>
                <p><strong>Nom :</strong> {{ $devis->createdBy->Username ?? 'Non spécifié' }}</p>
                <p><strong>Email :</strong> {{ $devis->createdBy->Email ?? 'Non spécifié' }}</p>
            </div>
            <div>
                <p><strong>Rôle :</strong> {{ $devis->createdBy->Role ?? 'Non spécifié' }}</p>
                <p><strong>Date de création :</strong> {{ $devis->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Détails du Devis</div>
        <div class="info-grid">
            <div>
                <p><strong>Date d'émission :</strong> {{ $devis->DateEmission ?? 'Non spécifié' }}</p>
                <p><strong>Date de validité :</strong> {{ $devis->DateValidite ?? 'Non spécifié' }}</p>
            </div>
            <div>
                <p><strong>Référence :</strong> {{ $devis->Reference }}</p>
                <p><strong>Statut :</strong> {{ $devis->Statut }}</p>
            </div>
        </div>
    </div>

    <div class="totals">
        <div class="section-title">Totaux</div>
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

    <div class="conditions">
        <div class="section-title">Conditions Générales</div>
        <div class="conditions-content">
            {!! $devis->ConditionsGenerales !!}
        </div>
    </div>

    <div class="signature">
        <div class="section-title">Signature</div>
        <p>Le client reconnaît avoir pris connaissance de ce devis et accepte les conditions générales.</p>
        <div>
            @if ($devis->signature)
                <p><strong>Signature du client :</strong></p>
                <img src="data:image/png;base64,{{ $devis->signature }}" alt="Signature du client">
            @endif
            <p><strong>Date :</strong> {{ $devis->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <div class="footer">
        <p>{{ config('app.name') }} - {{ $contactInfo->address ?? 'Adresse non spécifiée' }}</p>
        <p>Téléphone : {{ $contactInfo->phone ?? 'Non spécifié' }} | Email : {{ $contactInfo->email ?? 'Non spécifié' }}</p>
        <p>SIRET : {{ $contactInfo->siret ?? 'Non spécifié' }}</p>
    </div>
</body>
</html>
