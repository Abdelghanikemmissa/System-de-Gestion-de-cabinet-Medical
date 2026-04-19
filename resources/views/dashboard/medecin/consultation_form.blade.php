@extends('dashboard.medecin.layout')

@section('content')
<div class="max-w-3xl mx-auto py-10">
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
        <h2 class="text-2xl font-black text-slate-800 mb-6">Nouvelle consultation : {{ $patient->user->nom }}</h2>
        
        <form action="{{ route('medecin.consultation.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            
            <div class="mb-4">
                <label class="block font-bold text-slate-700">Motif</label>
                <input type="text" name="motif" required class="w-full border p-2 rounded">
            </div>

            <!-- <div class="mb-4">
                <label class="block font-bold text-slate-700">Observations</label>
                <textarea name="observations" required class="w-full border p-2 rounded"></textarea>
            </div> -->

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-xl">Enregistrer</button>
        </form>
    </div>
</div>
@endsection