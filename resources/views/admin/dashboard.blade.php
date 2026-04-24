<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediPlus - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hidden { display:none !important; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-green-50 flex min-h-screen">

<aside class="w-64 bg-white/90 backdrop-blur border-r border-blue-100 p-6 flex flex-col shadow-sm">
    <div class="flex items-center gap-3 mb-10">
        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-green-400 rounded-xl flex items-center justify-center text-white font-bold">M+</div>
        <span class="text-lg font-semibold text-slate-800">MediPlus</span>
    </div>

    <nav class="flex flex-col gap-2">
        <button onclick="switchTab('stats')" id="nav-stats" class="nav-link p-3 rounded-xl bg-gradient-to-r from-blue-500 to-green-400 text-white font-medium shadow-sm">Dashboard</button>
        <button onclick="switchTab('list-medecins')" id="nav-list-medecins" class="nav-link p-3 rounded-xl text-slate-600 hover:bg-blue-50 transition">👨‍⚕️ Médecins</button>
        <button onclick="switchTab('list-patients')" id="nav-list-patients" class="nav-link p-3 rounded-xl text-slate-600 hover:bg-blue-50 transition">👥 Patients</button>
        <button onclick="switchTab('form')" id="nav-form" class="nav-link p-3 rounded-xl text-slate-600 hover:bg-blue-50 transition">➕ Ajouter Membre</button>
    </nav>
</aside>

<main class="flex-1 p-10">
    <h1 id="main-title" class="text-3xl font-bold text-slate-800 mb-8">Tableau de bord</h1>

    <div id="view-stats" class="space-y-8">
        <div class="grid md:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <p class="text-sm text-slate-500">Médecins</p>
                <h2 class="text-2xl font-bold text-blue-600">{{ $stats['total_medecins'] }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <p class="text-sm text-slate-500">Secrétaires</p>
                <h2 class="text-2xl font-bold text-green-500">{{ $stats['total_secretaires'] }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <p class="text-sm text-slate-500">Patients</p>
                <h2 class="text-2xl font-bold text-purple-500">{{ $stats['total_patients'] }}</h2>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <p class="text-sm text-slate-500">Rendez-vous</p>
                <h2 class="text-2xl font-bold text-slate-700">{{ $stats['total_rdv'] }}</h2>
            </div>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <h3 class="font-semibold text-slate-700 mb-4">Personnel</h3>
                <canvas id="barChart"></canvas>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
                <h3 class="font-semibold text-slate-700 mb-4">Rendez-vous</h3>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

    <div id="view-list-medecins" class="hidden bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
        <table class="w-full text-left">
            <thead class="text-slate-400 text-sm border-b"><tr><th class="pb-3">Nom complet</th><th class="pb-3">Spécialité</th><th class="pb-3">Email</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($medecins as $m)
                <tr><td class="py-4">{{ $m->user->nom }} {{ $m->user->prenom }}</td><td class="py-4">{{ $m->specialite }}</td><td class="py-4">{{ $m->user->email }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="view-list-patients" class="hidden bg-white p-6 rounded-2xl shadow-sm border border-blue-100">
        <table class="w-full text-left">
            <thead class="text-slate-400 text-sm border-b"><tr><th class="pb-3">Nom</th><th class="pb-3">Email</th><th class="pb-3">CNI</th></tr></thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($patients as $p)
                <tr><td class="py-4">{{ $p->nom }} {{ $p->prenom }}</td><td class="py-4">{{ $p->email }}</td><td class="py-4">{{ $p->cni }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="view-form" class="hidden">
        <div class="max-w-2xl bg-white p-8 rounded-2xl shadow-sm border border-blue-100">
            <form action="{{ route('admin.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <input type="text" name="nom" placeholder="Nom" class="input" required>
                <input type="text" name="prenom" placeholder="Prénom" class="input" required>
                <input type="email" name="email" placeholder="Email" class="input" required>
                <input type="text" name="cni" placeholder="CNI" class="input" required>
                <input type="password" name="password" placeholder="Mot de passe" class="input col-span-2" required>
                <select name="role" class="input" onchange="toggleSpecialite(this.value)">
                    <option value="medecin">Médecin</option>
                    <option value="secretaire">Secrétaire</option>
                    <option value="admin">Admin</option>
                </select>
                <input type="text" name="specialite" id="spec" placeholder="Spécialité" class="input">
                <button class="col-span-2 bg-blue-600 text-white py-3 rounded-xl font-medium">Confirmer</button>
            </form>
        </div>
    </div>
</main>

<script>
    function switchTab(type) {
        document.querySelectorAll('[id^="view-"]').forEach(v => v.classList.add('hidden'));
        document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('bg-gradient-to-r','from-blue-500','to-green-400','text-white'));
        
        const view = document.getElementById('view-' + type);
        if(view) {
            view.classList.remove('hidden');
            document.getElementById('nav-' + type).classList.add('bg-gradient-to-r','from-blue-500','to-green-400','text-white');
        }
    }
    function toggleSpecialite(role) {
        document.getElementById('spec').style.display = (role === 'medecin') ? 'block' : 'none';
    }
</script>
</body>
</html>