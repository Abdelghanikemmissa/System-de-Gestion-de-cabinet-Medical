@extends('dashboard.medecin.layout')

@section('title', 'Gestion des disponibilités')

@section('content')

<div class="max-w-5xl mx-auto py-10 space-y-8">

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl shadow-sm flex items-center gap-3 animate-fade-in">
            <span class="text-xl">✅</span>
            <p class="font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- HEADER -->
    <div>
        <h2 class="text-3xl font-black text-slate-800 tracking-wide">Mes disponibilités</h2>
        <p class="text-slate-500 mt-1">Gérez vos créneaux de travail facilement.</p>
    </div>

    <!-- FORM -->
    <form action="{{ route('medecin.dispo.store') }}" method="POST" 
        class="bg-white/80 backdrop-blur p-6 rounded-3xl shadow-lg border border-slate-100 grid grid-cols-1 md:grid-cols-4 gap-5 items-end hover:shadow-xl transition">
        @csrf

        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-2">Date</label>
            <input type="date" name="date" 
                class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition hover:border-blue-300" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-2">Début</label>
            <input type="time" name="debut" 
                class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition hover:border-blue-300" required>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-600 mb-2">Fin</label>
            <input type="time" name="fin" 
                class="w-full border border-slate-200 p-3 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition hover:border-blue-300" required>
        </div>

        <button type="submit" 
            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-3 rounded-xl font-bold shadow-md hover:scale-105 hover:shadow-lg transition duration-300">
            + Ajouter
        </button>
    </form>

    <!-- LIST -->
    <div class="bg-white p-6 rounded-3xl shadow-md border border-slate-100">

        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6">
            <h3 class="font-bold text-lg text-slate-800">Prochaines disponibilités</h3>

            <form action="{{ route('medecin.dispo.index') }}" method="GET" class="flex gap-2">
                <input type="date" name="filter_date" value="{{ request('filter_date') }}" 
                    class="border border-slate-200 rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                <button type="submit" 
                    class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-black hover:scale-105 transition">
                    Filtrer
                </button>
            </form>
        </div>

        <div class="flex gap-5 overflow-x-auto pb-4 scroll-smooth">

            @forelse($disponibilites as $dispo)

            <div class="min-w-[160px] bg-gradient-to-br from-slate-50 to-white p-5 rounded-2xl border border-slate-200 text-center relative group hover:shadow-xl hover:-translate-y-1 transition duration-300">

                <!-- DELETE -->
                <form action="{{ route('medecin.dispo.destroy', $dispo->id) }}" method="POST" 
                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                    @csrf @method('DELETE')
                    <button class="bg-white shadow p-1 rounded-full text-red-500 hover:bg-red-100 hover:text-red-700 transition">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </form>

                <!-- DATE -->
                <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">
                    {{ $dispo->jour->format('d/m') }}
                </p>

                <!-- TIME -->
                <p class="font-black text-blue-600 text-xl mt-1">
                    {{ \Carbon\Carbon::parse($dispo->heure_debut)->format('H:i') }}
                </p>

                <p class="text-xs text-slate-500 mt-1">
                    à {{ \Carbon\Carbon::parse($dispo->heure_fin)->format('H:i') }}
                </p>

                <!-- HOVER LINE -->
                <div class="w-6 h-1 bg-blue-500 mx-auto mt-3 rounded-full group-hover:w-12 transition-all"></div>

            </div>

            @empty
            <p class="text-slate-400 w-full text-center py-10">
                Aucune disponibilité trouvée pour cette date.
            </p>
            @endforelse

        </div>

    </div>

</div>

@endsection