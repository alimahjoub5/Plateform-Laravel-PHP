@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mes Devis</h1>
        <div class="flex space-x-4">
            <div class="relative">
                <input type="text" id="searchDevis" placeholder="Rechercher un devis..." 
                    class="w-64 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select id="filterStatus" class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Tous les statuts</option>
                <option value="En attente">En attente</option>
                <option value="Accepté">Accepté</option>
                <option value="Refusé">Refusé</option>
                <option value="Modifications demandées">Modifications demandées</option>
            </select>
        </div>
    </div>

    @if ($devis->isEmpty())
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-blue-700">Vous n'avez aucun devis pour le moment.</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'émission</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de validité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total HT</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TVA</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total TTC</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($devis as $devi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $devi->Reference }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $devi->project->Title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($devi->DateEmission)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($devi->DateValidite)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($devi->TotalHT, 2, ',', ' ') }} €</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($devi->TVA, 2, ',', ' ') }} €</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ number_format($devi->TotalTTC, 2, ',', ' ') }} €</td>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('client.devis.show', $devi) }}" 
                                        class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-md transition duration-150 ease-in-out">
                                        <i class="fas fa-eye mr-1"></i> Voir
                                    </a>
                                    <a href="{{ route('client.devis.download', $devi) }}" 
                                        class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1 rounded-md transition duration-150 ease-in-out">
                                        <i class="fas fa-download mr-1"></i> PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Fonction de recherche
    document.getElementById('searchDevis').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });

    // Fonction de filtrage par statut
    document.getElementById('filterStatus').addEventListener('change', function() {
        const status = this.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (!status) {
                row.style.display = '';
                return;
            }
            
            const rowStatus = row.querySelector('td:nth-last-child(2) span').textContent.trim();
            row.style.display = rowStatus === status ? '' : 'none';
        });
    });
</script>
@endpush
@endsection