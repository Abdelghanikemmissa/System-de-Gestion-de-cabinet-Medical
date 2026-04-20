@extends('dashboard.medecin.layout')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
        <h2 class="text-2xl font-black text-slate-800 mb-6">
            Nouvelle consultation : {{ $patient->user->nom ?? 'Patient inconnu' }}
        </h2>
        
        <form action="{{ route('medecin.consultation.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            
            @isset($rendezvous)
                <input type="hidden" name="rendezvous_id" value="{{ $rendezvous->id }}">
            @else
                <p class="text-red-500 mb-4">Attention : Aucun rendez-vous associé à cette consultation.</p>
            @endisset
            
            <div class="mb-4">
                <label class="block font-bold text-slate-700">Compte rendu</label>
                <textarea name="compte_rendu" required class="w-full border p-2 rounded" rows="8"></textarea>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-blue-700">
                Enregistrer
            </button>
        </form>
    </div>
</div>
@endsection