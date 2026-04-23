<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secrétariat - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 font-sans flex text-slate-900">

<!-- Background -->
<div class="fixed inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover opacity-20" />
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900/80 to-slate-800/90"></div>
</div>

<!-- Sidebar -->
<aside class="w-72 bg-gradient-to-b from-slate-900 to-slate-800 h-screen sticky top-0 text-white p-6 flex flex-col shadow-2xl">
    <div class="mb-12 flex items-center gap-4">
        <div class="bg-emerald-500 p-3 rounded-2xl shadow-lg"></div>
        <span class="text-2xl font-extrabold">SecretaireCare</span>
    </div>

    <nav class="flex-1 space-y-3">
        <a href="{{ route('secretaire.dashboard') }}" class="flex items-center gap-3 text-slate-300 hover:bg-slate-700 p-4 rounded-xl transition">Dashboard</a>
        <a href="{{ route('secretaire.patients') }}" class="flex items-center gap-3 text-slate-300 hover:bg-slate-700 p-4 rounded-xl transition">Patients</a>
        <a href="{{ route('secretaire.rendezvous') }}" class="flex items-center gap-3 bg-emerald-500 text-white p-4 rounded-xl font-semibold shadow-md">Rendez-vous</a>
    </nav>

    <form action="{{ route('logout') }}" method="POST" class="mt-auto">
        @csrf
        <button class="w-full bg-red-500 hover:bg-red-600 p-3 rounded-xl font-semibold">Déconnexion</button>
    </form>
</aside>

<!-- Main -->
<main class="flex-1 p-10 space-y-10 overflow-y-auto">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-extrabold text-white">Rendez-vous</h1>
            <p class="text-slate-300">Gestion et historique des rendez-vous</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur rounded-3xl shadow-2xl overflow-hidden border">

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-500 text-xs uppercase bg-slate-100">
                        <th class="px-8 py-4">Patient</th>
                        <th class="px-8 py-4">Médecin</th>
                        <th class="px-8 py-4">Date</th>
                        <th class="px-8 py-4">Statut</th>
                        <th class="px-8 py-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($rendezvous as $rdv)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-8 py-5">
                            <div class="font-bold">{{ $rdv->patient->user->nom ?? 'N/A' }}</div>
                            <div class="text-xs text-slate-400">{{ $rdv->patient->user->email ?? '' }}</div>
                        </td>

                        <td class="px-8 py-5">Dr. {{ $rdv->medecin->user->nom ?? '' }}</td>

                        <td class="px-8 py-5">
                            {{ $rdv->date_heure->format('d/m/Y') }}
                            <div class="font-bold text-slate-800">{{ $rdv->date_heure->format('H:i') }}</div>
                        </td>

                        <td class="px-8 py-5">
                            @if($rdv->statut == 'en attente')
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-bold">En attente</span>
                            @elseif($rdv->statut == 'confirmé')
                                <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700 font-bold">Confirmé</span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-bold">Annulé</span>
                            @endif
                        </td>

                        <td class="px-8 py-5 text-center">
                            <div class="flex justify-center gap-3">
                                @if($rdv->statut == 'en attente')
                                <form action="{{ route('secretaire.confirmer', $rdv->id) }}" method="POST">
                                    @csrf
                                    <button class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-emerald-500 text-emerald-500 hover:bg-emerald-500 hover:text-white transition">
                                        ✓
                                    </button>
                                </form>

                                <form action="{{ route('secretaire.annuler', $rdv->id) }}" method="POST">
                                    @csrf
                                    <button class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-red-500 text-red-500 hover:bg-red-500 hover:text-white transition">
                                        ✕
                                    </button>
                                </form>
                                @else
                                <span class="text-slate-300 text-xs italic">Traité</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-400">Aucun rendez-vous</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

</body>
</html>
