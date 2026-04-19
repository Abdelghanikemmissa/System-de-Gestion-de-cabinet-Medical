@extends('dashboard.medecin.layout')

@section('content')

<div class="max-w-7xl mx-auto space-y-10">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-8 rounded-[2.5rem] shadow-xl flex flex-col md:flex-row justify-between items-center gap-6 hover:scale-[1.01] transition">

        <div class="flex items-center gap-6">

            <!-- AVATAR -->
            <div class="w-20 h-20 rounded-[2rem] bg-white/20 backdrop-blur flex items-center justify-center text-3xl font-black shadow-lg">
                {{ strtoupper(substr($patient->user->nom, 0, 1)) }}
            </div>

            <div>
                <h2 class="text-3xl font-black">
                    {{ $patient->user->nom }} {{ $patient->user->prenom }}
                </h2>

                <div class="flex flex-wrap items-center gap-4 mt-3 text-sm opacity-90">

                    <span class="flex items-center gap-1">
                        <i class="fas fa-fingerprint"></i> {{ $patient->user->cni }}
                    </span>

                    <span>•</span>

                    <span class="flex items-center gap-1">
                        <i class="fas fa-birthday-cake"></i>
                        {{ \Carbon\Carbon::parse($patient->date_naissance)->age }} ans
                    </span>

                    <span>•</span>

                    <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-bold">
                        {{ $patient->groupe_sanguin ?? 'Inconnu' }}
                    </span>

                </div>
            </div>
        </div>

        <!-- CTA -->
        <a href="{{ route('medecin.consultation.create', ['patient_id' => $patient->id]) }}" 
           class="bg-white text-blue-600 px-6 py-3 rounded-xl font-bold shadow-md hover:scale-105 hover:bg-blue-100 transition">
            <i class="fas fa-plus mr-2"></i> Nouvelle Consultation
        </a>

    </div>

    <!-- FILTER -->
    <div class="bg-white/80 backdrop-blur p-6 rounded-2xl shadow border border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">

        <h3 class="font-bold text-slate-700 flex items-center gap-2">
            <i class="fas fa-filter text-blue-500"></i> Filtrer par date
        </h3>

        <form method="GET" class="flex items-center gap-3">

            <input type="date" name="date" value="{{ request('date') }}"
                class="border border-slate-200 px-4 py-2 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">

            <button class="bg-blue-600 text-white px-5 py-2 rounded-xl font-bold hover:bg-blue-700 hover:scale-105 transition">
                Filtrer
            </button>

            <a href="{{ url()->current() }}" class="text-sm text-slate-400 hover:text-red-500">
                Reset
            </a>

        </form>

    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- INFOS -->
        <div class="space-y-6">

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow hover:shadow-lg transition">
                <h3 class="text-lg font-black mb-4">Informations</h3>

                <ul class="space-y-3 text-sm">

                    <li class="flex justify-between">
                        <span class="text-slate-400">Téléphone</span>
                        <span class="font-bold text-slate-700">{{ $patient->telephone }}</span>
                    </li>

                    <li class="flex justify-between">
                        <span class="text-slate-400">Sexe</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold
                            {{ $patient->sexe == 'M' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">
                            {{ $patient->sexe == 'M' ? 'Masculin' : 'Féminin' }}
                        </span>
                    </li>

                </ul>

            </div>

        </div>

        <!-- TABLE -->
        <div class="lg:col-span-2">

            <div class="bg-white rounded-3xl border border-slate-100 shadow-lg overflow-hidden">

                <div class="p-6 border-b">
                    <h3 class="text-xl font-black">Historique des consultations</h3>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-50 text-emerald-700 p-4 mx-6 mt-4 rounded-xl font-bold text-sm border">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto p-6">

                    <table class="w-full text-left">

                        <thead class="text-xs uppercase text-slate-400">
                            <tr>
                                <th class="pb-4">Date</th>
                                <th class="pb-4">Motif</th>
                                <th class="pb-4">Compte Rendu</th>
                                <th class="pb-4 text-right">Action</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y">

                        @php
                            $consultations = $patient->dossierMedical?->consultations ?? collect();
                            if(request('date')){
                                $consultations = $consultations->filter(fn($c) => \Carbon\Carbon::parse($c->created_at)->format('Y-m-d') == request('date'));
                            }
                            $consultations = $consultations->sortByDesc('created_at');
                        @endphp

                        @forelse($consultations as $consultation)

                        <tr class="group hover:bg-blue-50/40 transition">

                            <td class="py-5 font-bold text-slate-600">
                                {{ $consultation->created_at->format('d M Y') }}
                            </td>

                            <td class="py-5 font-semibold text-slate-800">
                                {{ $consultation->motif ?? '---' }}
                            </td>

                            <td class="py-5 text-slate-500 max-w-xs truncate">
                                {{ Str::limit($consultation->compte_rendu, 60) }}
                            </td>

                            <td class="py-5 text-right">

                                @if($consultation->ordonnance)

                                <a href="{{ route('medecin.ordonnance.pdf', $consultation->ordonnance->id) }}" target="_blank"
                                   class="text-emerald-600 font-bold text-xs hover:underline">
                                   Voir PDF
                                </a>

                                @else

                                <button onclick="showOrdonnanceForm({{ $consultation->id }})"
                                    class="text-blue-600 font-bold text-xs hover:underline">
                                    Générer
                                </button>

                                @endif

                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-400 italic">
                                Aucune consultation trouvée.
                            </td>
                        </tr>
                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- MODAL -->
<div id="ordonnance-modal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">

    <div class="bg-white p-8 rounded-3xl w-full max-w-lg shadow-2xl scale-95 opacity-0 transition-all duration-300" id="modal-content">

        <h3 class="font-black text-xl mb-4">Créer une ordonnance</h3>

        <form action="{{ route('medecin.ordonnance.store') }}" method="POST">
            @csrf

            <input type="hidden" name="consultation_id" id="modal_consultation_id">

            <textarea name="contenu"
                class="w-full border p-4 rounded-xl mb-4 focus:ring-2 focus:ring-blue-500 outline-none"
                rows="5" placeholder="Médicaments..." required></textarea>

            <div class="flex gap-3">

                <button type="button" onclick="closeModal()"
                    class="flex-1 bg-slate-100 py-3 rounded-xl font-bold hover:bg-slate-200">
                    Annuler
                </button>

                <button type="submit"
                    class="flex-1 bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700">
                    Générer
                </button>

            </div>

        </form>

    </div>

</div>

<script>
function showOrdonnanceForm(id) {
    document.getElementById('modal_consultation_id').value = id;

    const modal = document.getElementById('ordonnance-modal');
    const content = document.getElementById('modal-content');

    modal.classList.remove('hidden');

    setTimeout(() => {
        content.classList.remove('scale-95','opacity-0');
        content.classList.add('scale-100','opacity-100');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('ordonnance-modal');
    const content = document.getElementById('modal-content');

    content.classList.add('scale-95','opacity-0');

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 200);
}
</script>

@endsection