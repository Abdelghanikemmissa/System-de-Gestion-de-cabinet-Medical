@extends('dashboard.medecin.layout')

@section('title', 'Tableau de bord')

@section('content')

<!-- HEADER -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-8 rounded-[2.5rem] mb-10 flex justify-between items-center shadow-lg hover:scale-[1.01] transition duration-300">
    <div>
        <h1 class="text-3xl font-black tracking-wide">Bonsoir, Dr. {{ auth()->user()->nom }}</h1>
        <p class="opacity-80 text-sm mt-1">Tableau de bord professionnel</p>

        <div class="flex gap-4 mt-4 text-xs opacity-90">
            <span class="bg-white/10 px-3 py-1 rounded-full">❤️ Cabinet médical</span>
            <span class="bg-white/10 px-3 py-1 rounded-full">🛡️ Soins qualité</span>
        </div>
    </div>

</div>

<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <!-- RDV -->
    <div class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300">
        <p class="text-slate-400 text-sm mb-1">Rendez-vous</p>
        <h2 class="text-3xl font-black text-blue-600">{{ $rdvAujourdhui }}</h2>
        <div class="w-10 h-1 bg-blue-500 mt-2 rounded-full group-hover:w-16 transition-all"></div>
    </div>

    <!-- PATIENTS -->
    <div class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300">
        <p class="text-slate-400 text-sm mb-1">Patients</p>
        <h2 class="text-3xl font-black text-indigo-600">{{ $nbPatients }}</h2>
        <div class="w-10 h-1 bg-indigo-500 mt-2 rounded-full group-hover:w-16 transition-all"></div>
    </div>

    <!-- TAUX -->
    <div class="group bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition duration-300">
        <p class="text-slate-400 text-sm mb-1">Taux succès</p>
        <h2 class="text-3xl font-black text-green-500">25%</h2>
        <div class="w-10 h-1 bg-green-500 mt-2 rounded-full group-hover:w-16 transition-all"></div>
    </div>

</div>

<!-- MAIN -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- PROGRAMME -->
    <div class="md:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6 hover:shadow-lg transition">

        <h3 class="font-bold mb-5 text-lg">Programme d’aujourd’hui</h3>

        @foreach($rendezVous as $rdv)
        <div class="flex justify-between items-center p-4 rounded-xl hover:bg-blue-50 hover:scale-[1.01] transition duration-300">

            <div class="flex items-center gap-4">

                <div class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow">
                    {{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}
                </div>

                <div>
                    <p class="font-bold text-slate-800">
                        {{ $rdv->patient->user->nom }} {{ $rdv->patient->user->prenom }}
                    </p>
                    <p class="text-sm text-slate-400">Consultation</p>
                </div>
            </div>

            <a href="{{ route('medecin.dossier', $rdv->patient->id) }}" 
               class="bg-blue-50 text-blue-600 px-4 py-2 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white hover:scale-105 transition-all shadow-sm">
               <i class="fas fa-folder-open mr-1"></i> Voir dossier
            </a>
        </div>
        @endforeach

    </div>

    <!-- ACTIONS -->
    <div class="space-y-6">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg transition">

            <h3 class="font-bold mb-5 text-lg">Actions rapides</h3>

            <a href="{{ route('medecin.patients') }}" 
               class="flex items-center gap-3 w-full bg-slate-50 p-4 rounded-xl mb-3 hover:bg-blue-100 hover:scale-[1.02] transition font-semibold text-slate-700 shadow-sm">
                👤 Gérer patients
            </a>

            <a href="{{ route('medecin.planning') }}" 
               class="flex items-center gap-3 w-full bg-slate-50 p-4 rounded-xl mb-3 hover:bg-indigo-100 hover:scale-[1.02] transition font-semibold text-slate-700 shadow-sm">
                📅 Agenda
            </a>

            <a href="{{ route('medecin.dispo.index') }}" 
               class="flex items-center justify-center w-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white p-4 rounded-xl font-bold hover:opacity-90 hover:scale-105 transition shadow-md">
                ⏰ Gérer disponibilités
            </a>

        </div>

    </div>

</div>

@endsection