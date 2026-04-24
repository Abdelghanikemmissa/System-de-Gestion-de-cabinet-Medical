@extends('dashboard.patient.layouts.master')

@section('content')

<!-- Background -->
<div class="fixed inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1584982751601-97dcc096659c?q=80&w=1974&auto=format&fit=crop"
         class="w-full h-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-slate-900/80 to-slate-800/90"></div>
</div>

<div class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg bg-white/80 backdrop-blur-xl border border-white/30 shadow-2xl rounded-3xl p-8">

        <!-- Header -->
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-lg mb-3">
                📅
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800">Prendre un rendez-vous</h2>
            <p class="text-sm text-slate-500">Remplissez les informations ci-dessous</p>
        </div>

        <form action="{{ route('patient.rdv.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Date -->
            <div>
                <label class="text-sm font-semibold text-slate-600">Date et Heure</label>
                <input type="datetime-local"
                       name="date_heure"
                       required
                       class="w-full mt-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-400 outline-none bg-white/70">
            </div>

            <!-- Motif -->
            <div>
                <label class="text-sm font-semibold text-slate-600">Motif</label>
                <textarea name="motif"
                          rows="4"
                          required
                          placeholder="Décrivez le motif de votre consultation..."
                          class="w-full mt-1 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-400 outline-none bg-white/70"></textarea>
            </div>

            <!-- Button -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg transition">
                Confirmer le rendez-vous
            </button>
        </form>

    </div>

</div>

@endsection