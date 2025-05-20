@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Modifier l'Utilisateur</h1>
            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>

        <!-- Afficher les messages d'erreur -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->UserID) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Champ Username -->
                <div>
                    <label for="Username" class="block text-gray-700 font-medium mb-2">Username</label>
                    <input type="text" name="Username" id="Username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('Username', $user->Username) }}" required>
                    @error('Username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champ Email -->
                <div>
                    <label for="Email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="Email" id="Email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('Email', $user->Email) }}" required>
                    @error('Email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champ Mot de passe -->
                <div>
                    <label for="PasswordHash" class="block text-gray-700 font-medium mb-2">Mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" name="PasswordHash" id="PasswordHash" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('PasswordHash')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champ Rôle -->
                <div>
                    <label for="Role" class="block text-gray-700 font-medium mb-2">Rôle</label>
                    <select name="Role" id="Role" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="Freelancer" {{ old('Role', $user->Role) == 'Freelancer' ? 'selected' : '' }}>Freelancer</option>
                        <option value="Developer" {{ old('Role', $user->Role) == 'Developer' ? 'selected' : '' }}>Developer</option>
                        <option value="Client" {{ old('Role', $user->Role) == 'Client' ? 'selected' : '' }}>Client</option>
                        <option value="Admin" {{ old('Role', $user->Role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('Role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champ Langue -->
                <div>
                    <label for="Language" class="block text-gray-700 font-medium mb-2">Langue</label>
                    <select name="Language" id="Language" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="English" {{ old('Language', $user->Language) == 'English' ? 'selected' : '' }}>English</option>
                        <option value="Spanish" {{ old('Language', $user->Language) == 'Spanish' ? 'selected' : '' }}>Spanish</option>
                        <option value="French" {{ old('Language', $user->Language) == 'French' ? 'selected' : '' }}>French</option>
                        <option value="German" {{ old('Language', $user->Language) == 'German' ? 'selected' : '' }}>German</option>
                    </select>
                    @error('Language')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Champ Photo de profil -->
                <div>
                    <label for="ProfilePicture" class="block text-gray-700 font-medium mb-2">Photo de profil</label>
                    @if ($user->ProfilePicture)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $user->ProfilePicture) }}" alt="Photo de profil actuelle" class="w-32 h-32 rounded-lg object-cover border-2 border-gray-200">
                        </div>
                    @endif
                    <input type="file" name="ProfilePicture" id="ProfilePicture" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('ProfilePicture')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Champ Bio -->
            <div>
                <label for="Bio" class="block text-gray-700 font-medium mb-2">Bio</label>
                <textarea name="Bio" id="Bio" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('Bio', $user->Bio) }}</textarea>
                @error('Bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons d'action -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 ease-in-out">
                    <i class="fas fa-times mr-2"></i>Annuler
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endsection