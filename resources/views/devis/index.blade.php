@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <!-- En-tête -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-white">Liste des Devis</h1>
                <a href="{{ route('devis.create') }}" 
                    class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Créer un nouveau devis
                </a>
            </div>
        </div>

        <!-- Liste des devis -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total TTC</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($devis as $devi)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $devi->Reference }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $devi->client->Username }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $devi->project->Title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($devi->TotalTTC, 2, ',', ' ') }} €
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($devi->Statut == 'En attente') bg-yellow-100 text-yellow-800
                                        @elseif($devi->Statut == 'Accepté') bg-green-100 text-green-800
                                        @elseif($devi->Statut == 'Refusé') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $devi->Statut }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('devis.show', $devi->DevisID) }}" 
                                        class="text-blue-600 hover:text-blue-900" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('devis.edit', $devi->DevisID) }}" 
                                        class="text-indigo-600 hover:text-indigo-900" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('devis.destroy', $devi->DevisID) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ?')"
                                            title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    @if($devi->Statut == 'Accepté')
                                        @php
                                            $totalFactures = \App\Models\Invoice::where('ProjectID', $devi->ProjectID)->sum('Amount');
                                            $budgetProjet = $devi->project->Budget;
                                        @endphp
                                        
                                        @if($totalFactures < $budgetProjet)
                                            <a href="{{ route('invoices.create', ['projectID' => $devi->ProjectID, 'ClientID' => $devi->client->UserID]) }}"
                                               class="text-green-600 hover:text-green-900" title="Ajouter une facture">
                                                <i class="fas fa-file-invoice"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed" title="Budget atteint">
                                                <i class="fas fa-ban"></i>
                                            </span>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Aucun devis trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Inclure Font Awesome pour les icônes -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection