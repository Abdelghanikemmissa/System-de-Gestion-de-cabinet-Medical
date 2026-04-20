@extends('dashboard.patient.layouts.master')
@section('page-title', 'Modifier mon profil')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
    
    <form action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-8 flex items-center gap-6">
            <div class="relative">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.auth()->user()->prenom.'+'.auth()->user()->nom }}" 
                     class="w-24 h-24 rounded-full border-4 border-blue-50 object-cover shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Changer la photo</label>
                <input type="file" name="photo" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nom</label>
                <input type="text" name="nom" value="{{ old('nom', auth()->user()->nom) }}" class="w-full border border-gray-300 p-3 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Prénom</label>
                <input type="text" name="prenom" value="{{ old('prenom', auth()->user()->prenom) }}" class="w-full border border-gray-300 p-3 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone', auth()->user()->patient->telephone ?? '') }}" class="w-full border border-gray-300 p-3 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-bold text-gray-700 mb-2">Adresse</label>
            <input type="text" name="adresse" value="{{ old('adresse', auth()->user()->patient->adresse ?? '') }}" class="w-full border border-gray-300 p-3 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="border-t pt-6 mt-6">
            <h3 class="text-md font-bold text-gray-800 mb-4">Sécurité (Laisser vide pour ne pas changer)</h3>
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nouveau mot de passe</label>
                <input type="password" name="password" class="w-full border border-gray-300 p-3 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 p-3 rounded-xl outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition mt-4 shadow-lg">
            Enregistrer les modifications
        </button>
    </form>
</div>
@endsection