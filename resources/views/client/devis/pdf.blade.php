<!DOCTYPE html>
<html>
<head>
    <title>Devis #{{ $devis->Reference }}</title>
    <style>
        /* Réglages généraux pour le format A4 */
        @page {
            size: A4;
            margin: 20mm; /* Marges standard pour l'impression */
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto;
            width: 100%;
            max-width: 800px; /* Largeur maximale pour le contenu */
            color: #000; /* Texte en noir */
            line-height: 1.4;
            font-size: 12px; /* Taille de police plus petite */
        }
        header {
            text-align: center;
            margin-bottom: 15px;
        }
        .company-logo {
            max-width: 80px; /* Logo plus petit */
            margin-bottom: 10px;
        }
        .company-info {
            margin-bottom: 15px;
        }
        .company-info p {
            margin: 3px 0; /* Espacement réduit */
        }
        h1 {
            text-align: center;
            font-size: 16px; /* Taille de police plus petite */
            margin-bottom: 10px;
            color: #000; /* Titre en noir */
        }
        h2 {
            font-size: 14px; /* Taille de police plus petite */
            color: #000; /* Titre en noir */
            border-bottom: 1px solid #000; /* Bordure noire */
            padding-bottom: 3px;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 10px;
        }
        .section p {
            margin: 5px 0; /* Espacement réduit */
        }
        .section strong {
            color: #000; /* Texte en noir */
        }
        .totals {
            border: 1px solid #000; /* Bordure noire */
            padding: 10px;
            margin-bottom: 10px;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals table td {
            padding: 5px;
            border-top: 1px solid #000; /* Bordure noire */
        }
        .totals table td:first-child {
            font-weight: bold;
            text-align: right;
        }
        .conditions {
            border: 1px solid #000; /* Bordure noire */
            padding: 10px;
            margin-bottom: 10px;
        }
        .signature {
            border: 1px solid #000; /* Bordure noire */
            padding: 10px;
            margin-bottom: 10px;
        }
        .signature p {
            margin: 0;
        }
        .signature div {
            margin-top: 10px;
        }
        footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px; /* Taille de police plus petite */
            color: #000; /* Texte en noir */
        }
        @media print {
            body {
                margin: 20mm; /* Marges pour l'impression */
            }
            header, footer {
                display: none; /* Masquer le header et le footer à l'impression */
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
        <!-- Afficher la signature si elle existe -->
        @if ($devis->signature)
            <p>Signature du client :</p>
            <img src="{{ $devis->signature }}" alt="Signature du client" style="max-width: 100%; height: auto; border: 1px solid #000;">
        @else
            <p>Signature du client : _________________________</p>
        @endif
        <p>Date : {{ now()->format('d/m/Y') }}</p> <!-- Afficher la date actuelle -->
    </div>
</div>
    </main>
    <footer>
        <p>Contact : {{ $contactInfo->email }} | Téléphone : {{ $contactInfo->Phone }}</p>
    </footer>
</body>
</html>