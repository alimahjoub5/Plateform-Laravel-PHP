<!-- resources/views/profile.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <!-- Titre de la page -->
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Profil</h1>

            <!-- Formulaire de mise à jour du profil -->
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Section Photo de profil -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                    <div class="flex items-center">
                        <!-- Afficher la photo de profil actuelle -->
<div class="mr-4">
    @if($user->ProfilePicture && Storage::disk('public')->exists($user->ProfilePicture))
        <img src="{{ asset('storage/' . $user->ProfilePicture) }}"
            alt="Photo de profil"
            class="w-20 h-20 rounded-full object-cover">
    @else
        <img src="{{ asset('images/default-avatar.png') }}"
            alt="Photo de profil par défaut"
            class="w-20 h-20 rounded-full object-cover">
    @endif
</div>
                        <!-- Champ pour télécharger une nouvelle photo -->
                        <div>
                            <input type="file" name="ProfilePicture" id="ProfilePicture"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('ProfilePicture')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section Nom d'utilisateur -->
                <div class="mb-6">
                    <label for="Username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                    <input type="text" name="Username" id="Username"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Username') border-red-500 @enderror"
                        value="{{ old('Username', $user->Username) }}" required>
                    @error('Username')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section Prénom -->
                <div class="mb-6">
                    <label for="FirstName" class="block text-sm font-medium text-gray-700">Prénom</label>
                    <input type="text" name="FirstName" id="FirstName"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('FirstName') border-red-500 @enderror"
                        value="{{ old('FirstName', $user->FirstName) }}" required>
                    @error('FirstName')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section Nom -->
                <div class="mb-6">
                    <label for="LastName" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="LastName" id="LastName"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('LastName') border-red-500 @enderror"
                        value="{{ old('LastName', $user->LastName) }}" required>
                    @error('LastName')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section Téléphone -->
                <div class="mb-6">
                    <label for="PhoneNumber" class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                    <input type="text" name="PhoneNumber" id="PhoneNumber"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('PhoneNumber') border-red-500 @enderror"
                        value="{{ old('PhoneNumber', $user->PhoneNumber) }}">
                    @error('PhoneNumber')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section Adresse -->
                <div class="mb-6">
                    <label for="Address" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <textarea name="Address" id="Address" rows="3"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Address') border-red-500 @enderror">{{ old('Address', $user->Address) }}</textarea>
                    @error('Address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section Email -->
                <div class="mb-6">
                    <label for="Email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                    <input type="email" name="Email" id="Email"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Email') border-red-500 @enderror"
                        value="{{ old('Email', $user->Email) }}" required>
                    @error('Email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section Bio -->
                <div class="mb-6">
                    <label for="Bio" class="block text-sm font-medium text-gray-700">Bio</label>
                    <textarea name="Bio" id="Bio" rows="4"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Bio') border-red-500 @enderror">{{ old('Bio', $user->Bio) }}</textarea>
                    @error('Bio')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section Langue -->
                <div class="mb-6">
                    <label for="Language" class="block text-sm font-medium text-gray-700">Langue préférée</label>
                    <select name="Language" id="Language"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('Language') border-red-500 @enderror">
                        <option value="English" {{ $user->Language === 'English' ? 'selected' : '' }}>English</option>
                        <option value="Spanish" {{ $user->Language === 'Spanish' ? 'selected' : '' }}>Spanish</option>
                        <option value="French" {{ $user->Language === 'French' ? 'selected' : '' }}>French</option>
                        <option value="German" {{ $user->Language === 'German' ? 'selected' : '' }}>German</option>
                    </select>
                    @error('Language')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bouton de mise à jour -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection