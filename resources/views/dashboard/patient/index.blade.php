@extends('dashboard.patient.layouts.master')
@section('page-title', 'Tableau de bord')

@section('content')

<!-- Background -->
<div class="fixed inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?q=80&w=1974&auto=format&fit=crop"
         class="w-full h-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/80 via-slate-900/80 to-slate-800/90"></div>
</div>

<div class="space-y-6">

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-white/80 backdrop-blur-xl p-6 rounded-2xl shadow-lg border border-white/30 hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Rendez-vous totaux</p>
                    <h2 class="text-3xl font-bold text-blue-600">{{ $nbrRendezvous }}</h2>
                </div>
                <i class="fas fa-calendar text-blue-500 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl p-6 rounded-2xl shadow-lg border border-white/30 hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Consultations</p>
                    <h2 class="text-3xl font-bold text-green-600">{{ $nbrConsultations }}</h2>
                </div>
                <i class="fas fa-file-medical text-green-500 text-3xl"></i>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl p-6 rounded-2xl shadow-lg border border-white/30 hover:scale-105 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Dernier Statut RDV</p>
                    <h2 class="text-lg font-bold text-purple-600">
                        {{ $derniersRdv->first()->statut ?? 'Aucun' }}
                    </h2>
                </div>
                <i class="fas fa-envelope text-purple-500 text-3xl"></i>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="bg-white/80 backdrop-blur-xl p-6 rounded-2xl shadow-lg border border-white/30">

        <h3 class="text-lg font-bold mb-4 text-slate-800">
            Suivi de vos rendez-vous
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <thead>
                    <tr class="text-slate-500 text-sm border-b">
                        <th class="py-2">Date</th>
                        <th class="py-2">Statut</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($derniersRdv as $rdv)
                    <tr class="border-b hover:bg-slate-50 transition">
                        <td class="py-3 font-medium text-slate-700">
                            {{ $rdv->date_heure }}
                        </td>

                        <td class="py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $rdv->statut == 'confirmer'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($rdv->statut) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection