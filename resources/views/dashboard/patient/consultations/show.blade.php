@extends('dashboard.patient.layouts.master')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold border-b pb-2 mb-4">Détails de la consultation</h2>
    
    <div class="mb-4">
        <label class="font-bold">Compte-rendu :</label>
        <p class="mt-2 bg-gray-50 p-4 rounded">{{ $consultation->compte_rendu }}</p>
    </div>

    <a href="{{ route('patient.consultations.index') }}" class="text-gray-600 underline">Retour à la liste</a>
</div>
@endsection