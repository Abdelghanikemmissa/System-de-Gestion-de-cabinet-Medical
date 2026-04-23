@extends('dashboard.patient.layouts.master')

@section('content')

<!-- Background -->
<div class="fixed inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?q=80&w=1974&auto=format&fit=crop"
         class="w-full h-full object-cover" />
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 via-blue-900/70 to-slate-800/90"></div>
</div>

<div class="max-w-6xl mx-auto p-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-3xl font-extrabold text-white">Historique des consultations</h2>
        <p class="text-slate-300 text-sm">Consultez toutes vos consultations médicales</p>
    </div>

    <!-- Card -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 overflow-hidden">

        @if($consultations->isEmpty())
            <div class="p-10 text-center text-slate-500">
                <div class="text-5xl mb-3">📄</div>
                Aucune consultation trouvée.
            </div>
        @else

        <div class="overflow-x-auto">
            <table class="w-full text-left">

                <!-- Head -->
                <thead>
                    <tr class="text-slate-500 text-xs uppercase bg-slate-100/70">
                        <th class="p-4">Date</th>
                        <th class="p-4">Médecin</th>
                        <th class="p-4 text-center">Action</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody>

                    @foreach($consultations as $c)
                    <tr class="border-b border-slate-100 hover:bg-slate-50/70 transition">

                        <!-- Date -->
                        <td class="p-4 font-medium text-slate-700">
                            <div class="flex flex-col">
                                <span class="font-bold">
                                    {{ $c->date_consultation->format('d/m/Y') }}
                                </span>
                                <span class="text-xs text-slate-400">
                                    {{ $c->date_consultation->format('H:i') }}
                                </span>
                            </div>
                        </td>

                        <!-- Doctor -->
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                                    D
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">
                                        Dr. {{ $c->rendezvous->medecin->user->nom ?? 'Inconnu' }}
                                    </p>
                                    <p class="text-xs text-slate-400">Médecin généraliste</p>
                                </div>
                            </div>
                        </td>

                        <!-- Action -->
                        <td class="p-4 text-center">
                            <a href="{{ route('patient.consultations.show', $c->id) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition shadow">
                                Voir
                            </a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        @endif

    </div>

</div>

@endsection