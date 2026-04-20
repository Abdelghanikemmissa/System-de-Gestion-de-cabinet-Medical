@extends('dashboard.patient.layouts.master')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Prendre un rendez-vous</h2>
    <form action="{{ route('patient.rdv.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label>Date et Heure</label>
            <input type="datetime-local" name="date_heure" class="w-full border p-2" required>
        </div>
        <div class="mb-4">
            <label>Motif</label>
            <textarea name="motif" class="w-full border p-2" required></textarea>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Confirmer</button>
    </form>
</div>
@endsection