<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - UI Pro++</title>
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
        <a href="{{ route('secretaire.patients') }}" class="flex items-center gap-3 bg-emerald-500 text-white p-4 rounded-xl font-semibold shadow-md">Patients</a>
        <a href="{{ route('secretaire.rendezvous') }}" class="flex items-center gap-3 text-slate-300 hover:bg-slate-700 p-4 rounded-xl transition">Rendez-vous</a>
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
            <h1 class="text-4xl font-extrabold text-white">Patients</h1>
            <p class="text-slate-300">Gestion complète des patients</p>
        </div>

        <!-- Search -->
        <input type="text" placeholder="Rechercher..." class="bg-white/80 backdrop-blur px-5 py-3 rounded-xl shadow outline-none" />
    </div>

    <!-- Table Card -->
    <div class="bg-white/90 backdrop-blur rounded-3xl shadow-2xl overflow-hidden border">

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-500 text-xs uppercase bg-slate-100">
                        <th class="px-8 py-4">Patient</th>
                        <th class="px-8 py-4">CNI</th>
                        <th class="px-8 py-4">Téléphone</th>
                        <th class="px-8 py-4">Adresse</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($patients as $patient)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($patient->user->nom,0,1)) }}
                                </div>
                                <div>
                                    <p class="font-bold">{{ $patient->user->nom }} {{ $patient->user->prenom }}</p>
                                    <p class="text-xs text-slate-400">{{ $patient->user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-5 font-medium">{{ $patient->user->cni }}</td>
                        <td class="px-8 py-5">{{ $patient->telephone }}</td>
                        <td class="px-8 py-5">{{ $patient->adresse }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400">Aucun patient</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</main>

</body>
</html>
