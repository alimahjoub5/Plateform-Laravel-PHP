@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier l'Utilisateur</h1>

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

            <!-- Champ Username -->
            <div>
                <label for="Username" class="block text-gray-700">Username</label>
                <input type="text" name="Username" id="Username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('Username', $user->Username) }}" required>
                @error('Username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ Email -->
            <div>
                <label for="Email" class="block text-gray-700">Email</label>
                <input type="email" name="Email" id="Email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('Email', $user->Email) }}" required>
                @error('Email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ Mot de passe -->
            <div>
                <label for="PasswordHash" class="block text-gray-700">Mot de passe (laisser vide pour ne pas changer)</label>
                <input type="password" name="PasswordHash" id="PasswordHash" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('PasswordHash')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ Rôle -->
            <div>
                <label for="Role" class="block text-gray-700">Rôle</label>
                <select name="Role" id="Role" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="Developer" {{ old('Role', $user->Role) == 'Developer' ? 'selected' : '' }}>Developer</option>
                    <option value="Client" {{ old('Role', $user->Role) == 'Client' ? 'selected' : '' }}>Client</option>
                    <option value="Admin" {{ old('Role', $user->Role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('Role')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ Photo de profil -->
            <div>
                <label for="ProfilePicture" class="block text-gray-700">Photo de profil</label>
                @if ($user->ProfilePicture)
                    <img src="{{ asset('storage/' . $user->ProfilePicture) }}" alt="Photo de profil actuelle" class="mt-1 w-32 h-32 rounded-lg object-cover">
                @endif
                <input type="file" name="ProfilePicture" id="ProfilePicture" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mt-2">
                @error('ProfilePicture')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ Bio -->
            <div>
                <label for="Bio" class="block text-gray-700">Bio</label>
                <textarea name="Bio" id="Bio" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('Bio', $user->Bio) }}</textarea>
                @error('Bio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champ Langue -->
            <div>
                <label for="Language" class="block text-gray-700">Langue</label>
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

            <!-- Bouton de soumission -->
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                Mettre à jour
            </button>
        </form>

        <!-- Bouton de retour -->
        <div class="mt-6">
            <a href="{{ route('users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md transition duration-300 ease-in-out">
                Retour à la liste
            </a>
        </div>
    </div>
@endsection