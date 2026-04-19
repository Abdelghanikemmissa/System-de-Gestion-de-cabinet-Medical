@extends('layouts.app')

@section('content')
<div class="py-4 space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Bonjour, Dr. {{ auth()->user()->nom }} 👋</h1>
            <p class="text-slate-400 text-sm font-medium">Voici l'activité de votre cabinet pour aujourd'hui.</p>
        </div>
        <div class="text-right">
            <p class="text-sm font-bold text-slate-900">{{ now()->translatedFormat('d F Y') }}</p>
            <p class="text-xs text-blue-600 font-bold uppercase tracking-widest">{{ now()->translatedFormat('l') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-white shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Patients</p>
                <p class="text-2xl font-black text-slate-900">{{ $nbPatients ?? 0 }}</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-[2rem] border border-white shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Rendez-vous</p>
                <p class="text-2xl font-black text-slate-900">{{ $rdvAujourdhui ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-white shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-xl">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">En attente</p>
                <p class="text-2xl font-black text-slate-900">4</p>
            </div>
        </div>

        <div class="bg-blue-600 p-6 rounded-[2rem] shadow-lg shadow-blue-200 flex items-center gap-4 text-white">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center text-xl">
                <i class="fas fa-plus"></i>
            </div>
            <button class="font-bold text-sm text-left leading-tight">Nouvelle<br>Consultation</button>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-white shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-900">File d'attente du jour</h3>
            <a href="#" class="text-blue-600 text-sm font-bold">Voir tout le planning</a>
        </div>
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
                    <th class="px-8 py-4">Heure</th>
                    <th class="px-8 py-4">Nom du Patient</th>
                    <th class="px-8 py-4">Statut</th>
                    <th class="px-8 py-4 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($rendezVous as $rdv)
                <tr class="hover:bg-slate-50 transition-all group">
                    <td class="px-8 py-6">
                        <span class="text-blue-600 font-extrabold">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-bold text-slate-900 group-hover:text-blue-600">{{ $rdv->patient->user->nom }} {{ $rdv->patient->user->prenom }}</p>
                        <p class="text-[10px] text-slate-400 font-medium tracking-wide">CNI : {{ $rdv->patient->user->cni }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-4 py-1.5 bg-emerald-100 text-emerald-600 rounded-full text-[10px] font-black uppercase">Confirmé</span>
                    </td>
                    <td class="px-8 py-6 text-right">
                        <a href="{{ route('medecin.consultation.create', $rdv->patient_id) }}" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-xs font-bold hover:bg-blue-600 transition-all shadow-md">
                            COMMENCER
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection