@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Utilisateurs</h1>
            <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>Créer un Utilisateur
            </a>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="role_filter" class="block text-sm font-medium text-gray-700 mb-2">Filtrer par rôle</label>
                    <select id="role_filter" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les rôles</option>
                        <option value="Freelancer">Freelancer</option>
                        <option value="Developer">Developer</option>
                        <option value="Client">Client</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                    <input type="text" id="search" placeholder="Rechercher par nom ou email..." class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex items-end">
                    <button id="reset_filters" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
                        <i class="fas fa-redo mr-2"></i>Réinitialiser
                    </button>
                </div>
            </div>
        </div>

        <!-- Tableau des utilisateurs -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Langue</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->UserID }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($user->ProfilePicture)
                                        <img src="{{ asset('storage/' . $user->ProfilePicture) }}" alt="Photo de profil" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->Username }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->Email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $user->Role === 'Admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $user->Role === 'Developer' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $user->Role === 'Freelancer' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $user->Role === 'Client' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ $user->Role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->Language }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('users.show', $user->UserID) }}" class="text-blue-600 hover:text-blue-900" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', $user->UserID) }}" class="text-yellow-600 hover:text-yellow-900" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->UserID) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <div class="flex justify-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Filtrage des utilisateurs
        document.getElementById('role_filter').addEventListener('change', filterUsers);
        document.getElementById('search').addEventListener('input', filterUsers);
        document.getElementById('reset_filters').addEventListener('click', resetFilters);

        function filterUsers() {
            const role = document.getElementById('role_filter').value.toLowerCase();
            const search = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const userRole = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                const username = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const email = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                const roleMatch = !role || userRole === role;
                const searchMatch = !search || username.includes(search) || email.includes(search);

                row.style.display = roleMatch && searchMatch ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('role_filter').value = '';
            document.getElementById('search').value = '';
            filterUsers();
        }
    </script>
    @endpush
@endsection