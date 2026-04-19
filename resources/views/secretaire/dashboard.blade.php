<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secrétariat - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f1f5f9] font-sans flex text-slate-900">

    <aside class="w-64 bg-slate-900 h-screen sticky top-0 text-white p-6 flex flex-col">
        <div class="mb-10 flex items-center gap-3">
            <div class="bg-emerald-500 p-2 rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <span class="text-xl font-bold tracking-wider">MED-FLOW</span>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="{{ route('secretaire.dashboard') }}" class="flex items-center gap-3 bg-emerald-600/20 text-emerald-400 p-3 rounded-xl font-medium">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('secretaire.patients') }}" class="flex items-center gap-3 text-slate-400 hover:bg-slate-800 p-3 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Patients
            </a>
            <a href="{{ route('secretaire.rendezvous') }}" class="flex items-center gap-3 text-slate-400 hover:bg-slate-800 p-3 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Rendez-vous
            </a>
        </nav>

        <div class="pt-6 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex items-center gap-3 text-red-400 hover:bg-red-400/10 w-full p-3 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-10 overflow-y-auto">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Tableau de Bord</h2>
                <p class="text-slate-500">Gérez les rendez-vous et les patients aujourd'hui</p>
            </div>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-slate-400 text-sm font-bold uppercase tracking-wider mb-2">RDV Aujourd'hui</p>
                <h3 class="text-4xl font-black text-slate-800">{{ $stats['today_rv'] ?? 0 }}</h3>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-slate-400 text-sm font-bold uppercase tracking-wider mb-2">Total Patients</p>
                <h3 class="text-4xl font-black text-slate-800">{{ $stats['new_patients'] ?? 0 }}</h3>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <p class="text-slate-400 text-sm font-bold uppercase tracking-wider mb-2">En attente</p>
                <h3 class="text-4xl font-black text-slate-800">{{ $stats['pending'] ?? 0 }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                <h3 class="font-bold text-lg text-slate-800">Demandes de rendez-vous récents</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-4 font-semibold">Patient</th>
                            <th class="px-8 py-4 font-semibold">Médecin</th>
                            <th class="px-8 py-4 font-semibold">Date</th>
                            <th class="px-8 py-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rendezvous as $rdv)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-8 py-5 font-bold text-slate-700">{{ $rdv->patient->user->nom }} {{ $rdv->patient->user->prenom }}</td>
                            <td class="px-8 py-5 text-slate-600">Dr. {{ $rdv->medecin->user->nom }}</td>
                            <td class="px-8 py-5 text-slate-600">{{ $rdv->date_heure->format('d/m/Y H:i') }}</td>
                            <td class="px-8 py-5">
                                <form action="{{ route('secretaire.confirmer', $rdv->id) }}" method="POST">
                                    @csrf
                                    <button class="bg-slate-900 text-white text-xs px-4 py-2 rounded-lg hover:bg-emerald-600 transition font-bold uppercase">Confirmer</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="p-12 text-center text-slate-400">Aucun rendez-vous.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>