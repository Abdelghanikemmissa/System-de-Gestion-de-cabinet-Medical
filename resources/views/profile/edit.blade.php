@extends('layouts.app') 

@section('title', 'Modifier mon profil')

@section('content')
<div class="max-w-2xl bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
    <form action="{{ route('medecin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="flex items-center gap-6">
            <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://i.pravatar.cc/100?u='.auth()->user()->id }}" 
                 class="w-20 h-20 rounded-full border-4 border-slate-50 shadow-md">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Photo de profil</label>
                <input type="file" name="photo" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold text-slate-600">Nom</label>
                <input type="text" name="nom" value="{{ auth()->user()->nom }}" class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-600">Prénom</label>
                <input type="text" name="prenom" value="{{ auth()->user()->prenom }}" class="w-full mt-1 p-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition">
            Enregistrer les modifications
        </button>
    </form>
</div>
@endsection