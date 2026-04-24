<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secrétariat - Dashboard </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-sans flex text-slate-900">

    <div class="fixed inset-0 -z-10">
        <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover opacity-20" />
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 to-slate-800/90"></div>
    </div>

    <aside class="w-72 bg-gradient-to-b from-slate-900 to-slate-800 h-screen sticky top-0 text-white p-6 flex flex-col shadow-2xl">
        <div class="mb-12 flex items-center gap-4">
            <div class="bg-emerald-500 p-3 rounded-2xl shadow-lg">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <span class="text-2xl font-extrabold tracking-wide">MediPlus</span>
        </div>

        <nav class="flex-1 space-y-3">
            <a href="{{ route('secretaire.dashboard') }}" class="flex items-center gap-3 bg-emerald-500 text-white p-4 rounded-xl font-semibold shadow-md">Dashboard</a>
            <a href="{{ route('secretaire.patients') }}" class="flex items-center gap-3 text-slate-300 hover:bg-slate-700 p-4 rounded-xl transition">Patients</a>
            <a href="{{ route('secretaire.rendezvous') }}" class="flex items-center gap-3 text-slate-300 hover:bg-slate-700 p-4 rounded-xl transition">Historique</a>
        </nav>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-xl font-semibold shadow-md">
                Déconnexion
            </button>
        </form>
    </aside>

    <main class="flex-1 p-10 space-y-10 overflow-y-auto">

        @if (session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r-xl shadow-md">
                <p class="font-bold">Succès</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="flex justify-between items-center">
            <h1 class="text-4xl font-extrabold text-slate-800">Dashboard</h1>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('secretaire.create') }}" 
                   class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Ajouter un Patient
                </a>

                <div class="bg-white px-5 py-3 rounded-xl shadow-sm border">
                    <span class="text-sm text-slate-500">Bienvenue 👋</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-3xl shadow-lg border hover:scale-105 transition">
                <p class="text-slate-400 text-xs uppercase font-bold mb-2">RDV Aujourd'hui</p>
                <h3 class="text-5xl font-extrabold text-blue-600">{{ $stats['today_rv'] ?? 0 }}</h3>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-lg border hover:scale-105 transition">
                <p class="text-slate-400 text-xs uppercase font-bold mb-2">Total Patients</p>
                <h3 class="text-5xl font-extrabold text-emerald-500">{{ $stats['new_patients'] ?? 0 }}</h3>
            </div>
            <div class="bg-white p-8 rounded-3xl shadow-lg border hover:scale-105 transition">
                <p class="text-slate-400 text-xs uppercase font-bold mb-2">En attente</p>
                <h3 class="text-5xl font-extrabold text-red-500">{{ $stats['pending'] ?? 0 }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 bg-white rounded-3xl shadow-lg p-6 border">
                <h3 class="text-xl font-bold mb-6">Programme d’aujourd’hui</h3>
                @forelse($rendezVous as $rdv)
                <div class="flex justify-between items-center p-4 rounded-xl hover:bg-blue-50 transition mb-3">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm font-bold shadow">
                            {{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $rdv->patient->user->nom ?? 'Inconnu' }} {{ $rdv->patient->user->prenom ?? '' }}</p>
                            <p class="text-sm text-slate-400">Consultation</p>
                        </div>
                    </div>
                    <span class="text-green-500 text-sm font-bold">Confirmé</span>
                </div>
                @empty
                <p class="text-center text-slate-400 p-6">Aucun rendez-vous aujourd'hui</p>
                @endforelse
            </div>

            <div class="bg-white rounded-3xl shadow-lg p-6 border">
                <h3 class="text-xl font-bold mb-6">Demandes en attente</h3>
                <div class="space-y-4">
                    @forelse($rendezvousPending as $rdv)
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <p class="font-semibold text-sm">{{ $rdv->patient->user->nom ?? 'Inconnu' }}</p>
                        <form action="{{ route('secretaire.confirmer', $rdv->id) }}" method="POST">
                            @csrf
                            <button class="bg-emerald-500 hover:bg-emerald-600 text-white text-xs px-4 py-2 rounded-lg shadow">Valider</button>
                        </form>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 text-sm">Aucune demande</p>
                    @endforelse
                </div>
            </div>
        </div>

    </main>
</body>
</html>