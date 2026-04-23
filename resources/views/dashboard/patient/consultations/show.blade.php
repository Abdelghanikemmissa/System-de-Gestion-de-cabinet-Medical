@extends('dashboard.patient.layouts.master')

@section('content')

<!-- Background -->
<div class="fixed inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1580281657527-47e9d6c86c1b?q=80&w=1974&auto=format&fit=crop"
         class="w-full h-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 via-blue-900/70 to-slate-800/90"></div>
</div>

<div class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-3xl bg-white/80 backdrop-blur-xl border border-white/30 shadow-2xl rounded-3xl p-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">
                    Détails de la consultation
                </h2>
                <p class="text-sm text-slate-500">Compte rendu médical</p>
            </div>

            <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow">
                📄
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white/70 border border-slate-100 rounded-2xl p-6 shadow-sm">

            <label class="font-bold text-slate-700">Compte-rendu :</label>

            <p class="mt-3 text-slate-700 leading-relaxed whitespace-pre-line">
                {{ $consultation->compte_rendu }}
            </p>

        </div>

        <!-- Footer -->
        <div class="mt-6 flex justify-between items-center">

            <a href="{{ route('patient.consultations.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-300 transition shadow-sm">
                ← Retour à la liste
            </a>

            <button onclick="window.print()"
                    class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow">
                Imprimer
            </button>

        </div>

    </div>

</div>

@endsection
