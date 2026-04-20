@extends('dashboard.patient.layouts.master')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Rendez-vous totaux</p>
                <h2 class="text-2xl font-bold text-blue-600">{{ $nbrRendezvous }}</h2>
            </div>
            <i class="fas fa-calendar text-blue-500 text-2xl"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Consultations</p>
                <h2 class="text-2xl font-bold text-green-600">{{ $nbrConsultations }}</h2>
            </div>
            <i class="fas fa-file-medical text-green-500 text-2xl"></i>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Dernier Statut RDV</p>
                <h2 class="text-lg font-bold text-purple-600">
                    {{ $derniersRdv->first()->statut ?? 'Aucun' }}
                </h2>
            </div>
            <i class="fas fa-envelope text-purple-500 text-2xl"></i>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl shadow">
    <h3 class="text-lg font-bold mb-4">Suivi de vos rendez-vous</h3>
    <table class="w-full text-left">
        @foreach($derniersRdv as $rdv)
        <tr class="border-b">
            <td class="py-3">{{ $rdv->date_heure }}</td>
            <td class="py-3">
                <span class="px-2 py-1 rounded {{ $rdv->statut == 'confirmer' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($rdv->statut) }}
                </span>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection