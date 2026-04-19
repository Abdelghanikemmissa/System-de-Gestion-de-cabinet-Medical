<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secrétariat - Gestion des Rendez-vous</title>
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
            <a href="{{ route('secretaire.dashboard') }}" class="flex items-center gap-3 text-slate-400 hover:bg-slate-800 p-3 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('secretaire.patients') }}" class="flex items-center gap-3 text-slate-400 hover:bg-slate-800 p-3 rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Patients
            </a>
            <a href="{{ route('secretaire.rendezvous') }}" class="flex items-center gap-3 bg-emerald-600/20 text-emerald-400 p-3 rounded-xl font-medium">
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
                <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Gestion des Rendez-vous</h2>
                <p class="text-slate-500">Validez ou annulez les demandes de rendez-vous entrantes</p>
            </div>
        </header>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase tracking-widest bg-slate-50/50">
                            <th class="px-8 py-4 font-semibold">Patient</th>
                            <th class="px-8 py-4 font-semibold">Médecin</th>
                            <th class="px-8 py-4 font-semibold">Date & Heure</th>
                            <th class="px-8 py-4 font-semibold">Statut</th>
                            <th class="px-8 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rendezvous as $rdv)
                        <tr class="hover:bg-slate-50 transition group">
                            <td class="px-8 py-5">
                                <div class="font-bold text-slate-700">{{ $rdv->patient->user->nom ?? 'N/A' }} {{ $rdv->patient->user->prenom ?? '' }}</div>
                                <div class="text-xs text-slate-400">{{ $rdv->patient->user->email ?? '' }}</div>
                            </td>
                            <td class="px-8 py-5 text-slate-600">
                                <span class="font-medium text-slate-700">Dr. {{ $rdv->medecin->user->nom ?? 'Alami' }}</span>
                            </td>
                            <td class="px-8 py-5 text-slate-600">
                                {{ $rdv->date_heure->format('d/m/Y') }} à <span class="font-bold text-slate-800">{{ $rdv->date_heure->format('H:i') }}</span>
                            </td>
                            <td class="px-8 py-5">
                                @if($rdv->statut == 'en attente')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700 uppercase tracking-tighter">En attente</span>
                                @elseif($rdv->statut == 'confirmé')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 uppercase tracking-tighter">Confirmé</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 uppercase tracking-tighter">Annulé</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-center gap-4">
                                    @if($rdv->statut == 'en attente')
                                        <form action="{{ route('secretaire.confirmer', $rdv->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition shadow-sm">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>

                                        <form action="{{ route('secretaire.annuler', $rdv->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition shadow-sm">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-slate-300 text-[10px] font-bold uppercase italic tracking-widest">Traité</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-20 text-center text-slate-400">Aucun rendez-vous.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>