@extends('layouts.app') @section('content')
<div class="max-w-2xl bg-white p-8 rounded-2xl shadow-sm border">
    <h2 class="text-2xl font-black mb-6">Mon Profil</h2>
    
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-6 mb-8">
            <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://i.pravatar.cc/100?u='.auth()->user()->id }}" 
                 class="w-24 h-24 rounded-full border-4 shadow-lg">
            
            <div>
                <label class="block text-sm font-bold mb-2">Changer ma photo</label>
                <input type="file" name="photo" class="text-sm">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <input type="text" name="nom" value="{{ auth()->user()->nom }}" class="w-full p-3 border rounded-xl">
            <input type="text" name="prenom" value="{{ auth()->user()->prenom }}" class="w-full p-3 border rounded-xl">
        </div>

        <button type="submit" class="mt-6 w-full bg-blue-600 text-white py-3 rounded-xl font-bold">
            Enregistrer les modifications
        </button>
    </form>
</div>
@endsection